// Funciones especiales

$('#eliminar').click(() => {
    const fileID = $('#menu input').val()
    $('#menu').css('display', 'none')

    Swal.fire({
        title: "¡Cuidado!",
        text: "¿Esta seguro de eliminar este elemento?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: `Ok`,
    })
        .then((val) => {
            if (val.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'eliminar.php',
                    data: { fileID },
                    success: (r) => {
                        console.log(r)
                        //let res = JSON.parse(r);
                        /* if (res) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'success',
                                title: `Eliminando ${fileID}...`
                            }).then(() => {
                                window.location.reload()
                            })
                        } else {
                            Swal.fire("Oops...", "Hubo un error al eliminar.", "error")
                        } */
                    }
                });
            }
        })
})

$('#renombrar').click(() => {
    const oldName = $('#menu input').val()
    $('#menu').css('display', 'none')

    Swal.fire({
        title: 'Renombrar',
        text: 'Ingrese el nuevo nombre.',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Ok',
        preConfirm: (newName) => {
            if (newName == "") {
                return false
            }
            return $.ajax({
                type: 'POST',
                url: 'renombrar.php',
                data: { newName, oldName },
                success: (r) => {
                    return r
                }
            });
        }
    }).then((result) => {
        console.log(result)
        if (result.value == true) {
            Swal.fire({
                title: 'Renombrado correctamente.',
                icon: 'success'
            })
                .then(() => {
                    ;
                })
        }
        else {
            Swal.fire({
                title: 'Oops.',
                text: 'Ocurrió un error inesperado.',
                icon: 'error'
            })
        }
    })
})

$('#copiar').on('click', async function () {
    const fileID = $('#menu input').val()
    const hasCuted = false

    await $.ajax({
        type: 'POST',
        url: 'copiar.php',
        data: { fileID, hasCuted },
        success: (res) => {
            console.log('Copiado', res)
        }
    })

    $('#pegar').removeClass('disabled')

    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: false,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    await Toast.fire({
        icon: 'success',
        title: `${fileID} copiado`
    })

    window.location.reload()
})

$('#cortar').on('click', async function () {
    const fileID = $('#menu input').val()
    const hasCuted = true

    await $.ajax({
        type: 'POST',
        url: 'copiar.php',
        data: { fileID, hasCuted },
        success: (res) => {
            console.log('Cortado', res)
        }
    })

    $('#pegar').removeClass('disabled')
    $(`#${fileID}`).addClass('cuted')

    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: false,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: `${fileID} cortado`
    })
})

$('#propiedades').click(() => {
    const fileID = $('#menu input').val()
    $('#menu').css('display', 'none')

    /* const users =  */
    $.ajax({
        type: 'POST',
        url: 'usuarios.php',
        success: (res) => {
            console.log(res)
            //return res;
        }
    });

    Swal.fire({
        width: '60rem',
        title: "Propiedades del elemento",
        html: "Olakase",
        confirmButtonText: `Ok`
    })
})


// Navegación

$('.object.object-folder').click((e) => {
    const nameFolder = e.currentTarget.id;
    $.ajax({
        type: 'POST',
        data: { nameFolder },
        url: 'navegar.php',
        success: (r) => {
            let res = JSON.parse(r);
            if (res) {
                window.location.reload()
            } else {
                Swal.fire("Oops...", "A ocurrido un error inesperado.", "error")
            }
        }
    })
})

$('#irAtras').click(() => {
    $.ajax({
        type: 'POST',
        url: 'irAtras.php',
        success: (r) => {
            let res = JSON.parse(r);
            if (res) {
                window.location.reload()
            } else {
                Swal.fire("Oops...", "No puedes ir mas atras.", "error")
            }
        }
    });
})

// Abrir menu

$('.object').mousedown((e) => {
    $('#menu2').css('display', 'none');
    if (e.which == '3') {
        $('#menu').css('display', 'block')
        $('#menu').css('top', mouseY(e) + 'px')
        $('#menu').css('left', mouseX(e) + 'px')
        $('#menu input').val(e.currentTarget.id)
    }

})

$('#explorer').mousedown((e) => {

    if (e.target.id == "explorer") {
        $('#menu').css('display', 'none');
        if (e.which == '3') {
            $('#menu2').css('display', 'block')
            $('#menu2').css('top', mouseY(e) + 'px')
            $('#menu2').css('left', mouseX(e) + 'px')
        }
    }
})


// cerrar menu al clickear fuera de él

$(document).click(function (e) {
    $('#menu').css('display', 'none')
    $('#menu2').css('display', 'none')

    /* let id = 
    if (visible == "block" && id != "menu" ) {
        $('#menu').css('display', 'none')
    } */
});

// desactivar menu del DOM y dar mensaje de bienvenida una sola vez

$(document).ready(() => {
    if (!localStorage.greeting) {
        Swal.fire({
            title: 'Bienvenido al explorador de archivos construido en el curso Sistemas Operativos',
            text: "Universidad Nacional de Colombia - Medellín 2020-2",
            button: 'Ok'
        })
        localStorage.setItem('greeting', true)
    }

    document.addEventListener('contextmenu', event => event.preventDefault());
})

// Calcular posición del menu

function mouseX(evt) {
    if (evt.pageX) {
        return evt.pageX;
    } else if (evt.clientX) {
        return evt.clientX + (document.documentElement.scrollLeft ?
            document.documentElement.scrollLeft :
            document.body.scrollLeft);
    } else {
        return null;
    }
}

function mouseY(evt) {
    if (evt.pageY) {
        return evt.pageY;
    } else if (evt.clientY) {
        return evt.clientY + (document.documentElement.scrollTop ?
            document.documentElement.scrollTop :
            document.body.scrollTop);
    } else {
        return null;
    }
}