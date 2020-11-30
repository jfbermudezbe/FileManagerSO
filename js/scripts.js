// Renombrar

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
                        let res = JSON.parse(r);
                        if (res) {
                            Swal.fire("Muy bien!.", "Se eliminó correctamente.", "success")
                                .then((val) => {
                                    if (val) window.location.reload()
                                })

                        } else {
                            Swal.fire("Oops...", "Hubo un error al eliminar.", "error")
                        }
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
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Renombrado correctamente.',
                icon: 'success'
            })
                .then(() => {
                    window.location.reload();
                })

        }
    })
})

// Abrir menu

$('.object').mousedown((e) => {
    if (e.which == '3') {
        $('#menu').css('display', 'block')
        $('#menu').css('top', mouseY(e) + 'px')
        $('#menu').css('left', mouseX(e) + 'px')
        $('#menu input').val(e.currentTarget.id)
    }
})

// cerrar menu al clickear fuera de él

$(document).click(function (event) {
    let visible = $('#menu').css('display')
    let id = event.target.parentElement ? event.target.parentElement.id : event.target.id;
    if (visible == "block" && id != "menu") {
        $('#menu').css('display', 'none')
    }
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