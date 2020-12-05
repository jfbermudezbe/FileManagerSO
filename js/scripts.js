// Permisos

$('#cambiar_permisos').on('click', async () => {
    const fileID = $('#menu input').val()

    const res = await $.ajax({
        type: 'POST',
        url: 'cambiarPermiso.php',
        data: { action: 'get', fileID },
        success: (res) => {
            return JSON.parse(res)
        }
    });

    const u = res[1]
    const g = res[2]
    const o = res[3]

    const opciones = [0, 1, 2, 3, 4, 5, 6, 7]

    let html = `
    <br>
    <div class="row select-permissions">
        <div class="col-md-4">
            <div class="form-group">
                <label class="mr-sm-2">Usuario</label>
                <select class="custom-select mr-sm-2 permiso_usuario">`
    opciones.forEach(i => {
        html += `<option ${u == i ? 'selected' : ''} value="${i}">${i}</option>`
    })
    html += `
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="mr-sm-2">Grupo</label>
                <select class="custom-select mr-sm-2 permiso_grupo">`
    opciones.forEach(i => {
        html += `<option ${g == i ? 'selected' : ''} value="${i}">${i}</option>`
    })
    html += `</select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="mr-sm-2">Otros</label>
                <select class="custom-select mr-sm-2 permiso_otros">`
    opciones.forEach(i => {
        html += `<option ${o == i ? 'selected' : ''} value="${i}">${i}</option>`
    })
    html += `
                </select>
            </div>
        </div>
    </div>
    <small id='cambiarPermisoComment' class='form-text text-muted'>
        <br>
        <div class="container">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">7</th>
                        <td>Lectura, escritura y ejecución</td>
                    </tr>
                    <tr>
                        <th scope="row">6</th>
                        <td>Lectura y escritura</td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td>Lectura y ejecución</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>Lectura</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Escritura y ejecución</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Escritura</td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>Ejecución</td>
                    </tr>
                    <tr>
                        <th scope="row">0</th>
                        <td>Sin permisos</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </small>
    <br>`

    const res2 = await Swal.fire({
        title: "Ingrese el código del permiso",
        html: html,
        showCancelButton: true,
        showConfirmButton: true
    })

    if (res2.isDenied || res2.isDismissed) return

    const nuevoU = $('.select-permissions .permiso_usuario').val()
    const nuevoG = $('.select-permissions .permiso_grupo').val()
    const nuevoO = $('.select-permissions .permiso_otros').val()

    const nuevoP = nuevoU + '' + nuevoG + '' + nuevoO

    const res3 = await $.ajax({
        type: 'POST',
        url: 'cambiarPermiso.php',
        data: { action: 'set', fileID, nuevoP },
        success: (res) => {
            return res
        }
    })

    if (res3 == 0) {
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

        await Toast.fire({
            icon: 'success',
            title: `Cambiando permisos de ${fileID}...`,
            allowOutsideClick: false
        })

        window.location.reload()

    } else {
        Swal.fire("Oops...", "Hubo un error.", "error")
    }
})

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
                        let res = JSON.parse(r);
                        if (res) {
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
                                title: `Eliminando ${fileID}...`,
                                allowOutsideClick: false
                            }).then(() => {
                                window.location.reload()
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

        if (result.value == "true") {
            Swal.fire({
                title: 'Renombrado correctamente.',
                icon: 'success'
            })
                .then(() => {
                    window.location.reload();
                })
        }
        else {
            Swal.fire({
                title: 'Oops.',
                text: 'Ocurrió un error inesperado.',
                icon: 'error'
            })
                .then(() => {
                    window.location.reload();
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

$('#propiedades').click(async () => {
    const fileID = $('#menu input').val()
    $('#menu').css('display', 'none')

    const fileData = JSON.parse(await $.ajax({
        type: 'POST',
        url: 'usuarios.php',
        data: { fileID, action: 'propietarios' },
        success: (res) => {
            return res;
        }
    }));

    const modifiedDate = fileData.date[0].split(' ');

    let props = `
    <div class="row m-0">
        <p class="col-6 m-0">Propietario</p>
        <p class="col-6">${fileData.owner[0]}</p>
        <p class="col-6 m-0">Cambiar propietario</p>
        <div class="form-group col-6 m-0 select-users">
            <select class="form-control custom-select">
                <option selected value="-1">No cambiar</option>
            `
    fileData.users.forEach(user => {
        props += `<option value="${user}">${user}</option>`
    })

    props += `
            </select>
        </div>
        <hr class="col-11">
        <p class="col-6 m-0">Peso</p>
        <p class="col-6 m-0">${fileData.fileSize[0]} bytes</p>
        <hr class="col-11">
        <p class="col-6 m-0">Fecha de modificación (Año/Mes/Día)</p>
        <p class="col-6 m-0">${modifiedDate[0]}</p>
    </div>`

    await Swal.fire({
        width: '40rem',
        title: `Propiedades de ${fileID}`,
        html: props,
        confirmButtonText: `Ok`,
        customClass: {
            header: 'pb-3',
            content: 'p-0'
        }
    })

    const propietario = $('.select-users .custom-select').val()

    if (propietario == "-1") return

    const res = await $.ajax({
        type: 'POST',
        url: 'cambiarPropietario.php',
        data: { fileID, propietario },
        success: (res) => {
            return res
        }
    })

    if (res == 0) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            timer: 5000,
            timerProgressBar: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        await Toast.fire({
            icon: 'success',
            title: `Se cambió el propietario de ${fileID} al usuario ${propietario}`
        })
    }
    else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            timer: 2000,
            timerProgressBar: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        await Toast.fire({
            icon: 'error',
            title: `Ha ocurrido un error.`
        })
    }
})

$('#crearUsuario').click(async () => {
    const users = JSON.parse(await $.ajax({
        type: 'POST',
        url: 'usuarios.php',
        data: { action: 'todos' },
        success: (res) => {
            return res;
        }
    }))

    let props = `<div class="row m-0">`

    users.forEach(user => {
        props += `<div class="col-12 py-2">${user}</div>`
    })

    props += `
    </div>`

    const res = await Swal.fire({
        title: `Usuarios`,
        html: props,
        customClass: {
            header: 'pb-3',
            content: 'p-0'
        }
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
            if (r == "true") {
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

// Abrir menu PC

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
