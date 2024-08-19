<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><title>Formulario de Pedido</title><meta name="description" content=""><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"><style>body {
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background-color: #ffcc00; /* Amarillo suave */padding: 10px;
        }
        .navbar-customimg {
            height: 40px; /* Tamaño del logotipo */
        }
        .fixed-bottom-bar {
            background-color: #dc3545; /* Rojo oscuro */border-top: 1px solid #b52a1b;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 1030; /* Ensure it is above other content */
        }
        .btn-pagar {
            background-color: #28a745; /* Verde claro para contraste */color: white;
            border: none;
        }
        .btn-pagar:hover {
            background-color: #218838; /* Verde oscuro para hover */
        }
        .container-custom {
            margin-top: 20px;
            margin-bottom: 70px; /* Added margin to prevent content from being covered by the fixed bar */
        }
        .personalizacion-item {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #ffffff; /* Fondo blanco para contraste */
        }
        /* Styles for the modal */.modal-dialog {
            position: fixed;
            top: 20%;
            left: 35%;
            transform: translate(-50%, -50%);
            z-index: 1050; /* Ensure the modal is above everything */
        }
        .modal-content {
            padding: 20px;
        }
        .modal-bodylabel {
            margin-left: 10px;
            text-transform: capitalize; /* Capitalize the first letter */
        }
        .form-grouplabel {
            color: #dc3545; /* Rojo oscuro para las etiquetas */
        }
        .form-control {
            border-color: #dc3545; /* Rojo oscuro para los bordes de los inputs */
        }
        .btn-outline-secondary {
            color: #dc3545; /* Rojo oscuro para los botones */border-color: #dc3545;
        }
        .btn-outline-secondary:hover {
            background-color: #dc3545;
            color: white;
        }
        .logo {
        max-width: 100px; /* Cambia el tamaño aquí según lo necesites */margin-right: 50px;
        }

    </style></head><body><nav class="navbar navbar-expand-lg navbar-custom"><img src="Logo.jpg" alt="Logo" class=logo><h2>NANAMIS</h2></nav><div class="container container-custom"><form id="formulario" method="post"><h2 class="mb-4">Bienvenido, realice su pedido</h2><div class="form-group"><label for="banderillas">Banderillas:</label><div class="input-group"><button type="button" class="btn btn-outline-secondary" id="menos-banderillas">-</button><input type="number" id="banderillas" name="banderillas" min="0" max="10" value="0" class="form-control text-center"><button type="button" class="btn btn-outline-secondary" id="mas-banderillas">+</button></div></div><div class="form-group"><label for="limonadas">Limonadas:</label><div class="input-group"><button type="button" class="btn btn-outline-secondary" id="menos-limonadas">-</button><input type="number" id="limonadas" name="limonadas" min="0" max="10" value="0" class="form-control text-center"><button type="button" class="btn btn-outline-secondary" id="mas-limonadas">+</button></div></div><div id="banderillas-container"></div><div id="limonadas-container"></div></form></div><div class="fixed-bottom fixed-bottom-bar"><span id="total" class="text-white">Total: $0.00</span><button type="button" class="btn btn-pagar" data-toggle="modal" data-target="#confirmModal">Pagar</button></div><!-- Modal de Confirmación --><div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="confirmModalLabel">Confirmar Pedido</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div><div class="modal-body">
                    ¿Está seguro de que desea confirmar el pedido?
                </div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary" id="confirmar-pago">Pagar</button></div></div></div></div><script src="https://code.jquery.com/jquery-3.5.1.min.js"></script><script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script><script>
        const banderillasInput = document.getElementById('banderillas');
        const limonadasInput = document.getElementById('limonadas');
        const banderillasContainer = document.getElementById('banderillas-container');
        const limonadasContainer = document.getElementById('limonadas-container');
        const masBanderillasButton = document.getElementById('mas-banderillas');
        const menosBanderillasButton = document.getElementById('menos-banderillas');
        const masLimonadasButton = document.getElementById('mas-limonadas');
        const menosLimonadasButton = document.getElementById('menos-limonadas');
        const totalElement = document.getElementById('total');
        const banderillaPrice = 65;
        const limonadaPrice = 40;

        masBanderillasButton.addEventListener('click', () => {
            var currentValue = parseInt(banderillasInput.value);
            banderillasInput.value = currentValue + 1;
            createBanderillaPersonalizacion(currentValue + 1);
            actualizarTotal();
        });

        menosBanderillasButton.addEventListener('click', () => {
            var currentValue = parseInt(banderillasInput.value);
            if (currentValue > 0) {
                banderillasInput.value = currentValue - 1;
                removeBanderillaPersonalizacion(currentValue);
                actualizarTotal();
            }
        });

        masLimonadasButton.addEventListener('click', () => {
            const currentValue = parseInt(limonadasInput.value);
            limonadasInput.value = currentValue + 1;
            createLimonadaPersonalizacion(currentValue + 1);
            actualizarTotal();
        });

        menosLimonadasButton.addEventListener('click', () => {
            const currentValue = parseInt(limonadasInput.value);
            if (currentValue > 0) {
                limonadasInput.value = currentValue - 1;
                removeLimonadaPersonalizacion(currentValue);
                actualizarTotal();
            }
        });

        function createBanderillaPersonalizacion(index) {
            const container = document.getElementById('banderillas-container');

            const personalizacionDiv = document.createElement('div');
            personalizacionDiv.classList.add('personalizacion-item');
            personalizacionDiv.setAttribute("id", `item-${index}`);

            const fieldset = document.createElement('fieldset');
            const legend = document.createElement('legend');
            legend.textContent = `Banderilla ${index} - Personalización`;
            fieldset.appendChild(legend);

            const aderezosLabel = document.createElement('label');
            aderezosLabel.textContent = 'Aderezos:';
            fieldset.appendChild(aderezosLabel);

            const aderezosOptions = ['ketchup', 'ranch', 'chipotle', 'bufalo', 'bbq spicy'];
            aderezosOptions.forEach((option) => {
                const checkbox = createCheckbox(`banderilla-${index}-aderezo[]`, option, option);
                fieldset.appendChild(checkbox);
            });

            const empanizadoLabel = document.createElement('label');
            empanizadoLabel.textContent = 'Empanizado:';
            fieldset.appendChild(empanizadoLabel);

            const empanizadoOptions = ['ramen', 'clasico', 'frituras', 'papa'];
            empanizadoOptions.forEach((option) => {
                const checkbox = createCheckbox(`banderilla-${index}-empanizado[]`, option, option);
                fieldset.appendChild(checkbox);
            });

            const tipoLabel = document.createElement('label');
            tipoLabel.textContent = 'Tipo de Banderilla:';
            fieldset.appendChild(tipoLabel);

            const tipoOptions = ['y la queso', 'mixta', 'entera'];
            tipoOptions.forEach((option) => {
                const checkbox = createCheckbox(`banderilla-${index}-tipo[]`, option, option);
                fieldset.appendChild(checkbox);
            });

            personalizacionDiv.appendChild(fieldset);
            container.appendChild(personalizacionDiv);
        }

        function removeBanderillaPersonalizacion(index) {
            var item = 'item-' + index;
            var element = document.getElementById(item);
            if (element) {
                element.remove();
            }
        }

        function createLimonadaPersonalizacion(index) {
            const container = document.getElementById('limonadas-container');

            const personalizacionDiv = document.createElement('div');
            personalizacionDiv.classList.add('personalizacion-item');
            personalizacionDiv.setAttribute("id", `item-limonada-${index}`);

            const fieldset = document.createElement('fieldset');
            const legend = document.createElement('legend');
            legend.textContent = `Limonada ${index} - Personalización`;
            fieldset.appendChild(legend);

            const saboresLabel = document.createElement('label');
            saboresLabel.textContent = 'Sabores:';
            fieldset.appendChild(saboresLabel);

            const saboresOptions = ['limon', 'blue raspberry', 'mandarina', 'lima', 'coco', 'sandia'];
            saboresOptions.forEach((option) => {
                const checkbox = createCheckbox(`limonada-${index}-sabor[]`, option, option);
                fieldset.appendChild(checkbox);
            });

            personalizacionDiv.appendChild(fieldset);
            container.appendChild(personalizacionDiv);
        }

        function removeLimonadaPersonalizacion(index) {
            var item = 'item-limonada-' + index;
            var element = document.getElementById(item);
            if (element) {
                element.remove();
            }
        }

        function createCheckbox(name, value, labelText) {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = name;
            checkbox.value = value;

            const label = document.createElement('label');
            label.textContent = labelText;
            label.style.marginLeft = '10px'; // Agrega un espacio antes de la etiqueta.

            const checkboxContainer = document.createElement('div');
            checkboxContainer.appendChild(checkbox);
            checkboxContainer.appendChild(label);

            return checkboxContainer;
        }

        function actualizarTotal() {
            const banderillasCount = parseInt(banderillasInput.value) || 0;
            const limonadasCount = parseInt(limonadasInput.value) || 0;

            const total = (banderillasCount * banderillaPrice) + (limonadasCount * limonadaPrice);
            totalElement.textContent = `Total: $${total.toFixed(2)}`;
        }

        // Inicializar el total al cargar la página
        actualizarTotal();

        // Manejadores de eventos para el modal
        const confirmarPagoBtn = document.getElementById('confirmar-pago');
        const formulario = document.getElementById('formulario');

        confirmarPagoBtn.addEventListener('click', async () => {
            $('#confirmModal').modal('hide'); // Ocultar el modal
            // Crear un objeto FormData con los datos del formulario
            const formData = new FormData(formulario);

            try {
                // Enviar los datos del formulario a backend.php usando fetch
                const response = await fetch('backend.php', {
                    method: 'POST',
                    body: formData
                });

                // Verificar si la respuesta es exitosa
                if (response.ok) {
                    const result = await response.text();
                    alert(result); // Mostrar el mensaje de éxito o error
                    // Limpiar el formulario y los contenedores después de enviar
                    formulario.reset();
                    banderillasContainer.innerHTML = '';
                    limonadasContainer.innerHTML = '';
                    actualizarTotal();
                } else {
                    alert('Error al enviar la orden. Por favor, inténtelo de nuevo.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al enviar la orden. Por favor, inténtelo de nuevo.');
            }
        });
    </script></body></html>
