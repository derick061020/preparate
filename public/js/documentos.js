console.log('Documentos.js cargado');

class DocumentosManager {
    constructor() {
        this.uploading = false;
        console.log('DocumentosManager inicializado');
    }

    handleFileUpload(input, documentId, llcId) {
        console.log('Subiendo archivo para documento:', documentId);
        const file = input.files[0];
        if (!file) return;

        // Mostrar la barra de progreso
        const progressDiv = document.getElementById(`upload-progress-${documentId}`);
        progressDiv.classList.remove('hidden');
        const progressBar = progressDiv.querySelector('div');
        progressBar.style.width = '0%';

        // Crear el formulario de datos
        const formData = new FormData();
        formData.append('archivo', file);
        formData.append('document_id', documentId);
        formData.append('llc_id', llcId);

        // Crear la solicitud
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/documentos/upload', true);

        // Manejar el progreso
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                const percent = (e.loaded / e.total) * 100;
                progressBar.style.width = percent + '%';
            }
        };

        // Manejar el éxito
        xhr.onload = function() {
            console.log('Respuesta del servidor:', xhr.responseText);
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Actualizar el estado del documento
                    const label = input.closest('div').querySelector('label');
                    label.innerHTML = 'Archivo Subido';
                    label.style.backgroundColor = '#10b981';
                    label.style.color = '#ffffff';
                    
                    // Emitir evento para refrescar la tabla
                    window.dispatchEvent(new Event('llcUpdated'));
                }
            }
        };

        // Manejar el error
        xhr.onerror = function() {
            console.error('Error en la subida del archivo');
            const label = input.closest('div').querySelector('label');
            label.innerHTML = 'Error al subir';
            label.style.backgroundColor = '#ef4444';
            label.style.color = '#ffffff';
        };

        // Enviar la solicitud
        console.log('Enviando solicitud...');
        xhr.send(formData);
    }

    initialize() {
        console.log('Inicializando listeners...');
        const fileInputs = document.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            input.addEventListener('change', (e) => {
                console.log('Archivo seleccionado:', e.target.files[0].name);
                this.handleFileUpload(e.target, input.dataset.documentId, input.dataset.llcId);
            });
        });
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, inicializando DocumentosManager');
    window.documentosManager = new DocumentosManager();
    window.documentosManager.initialize();
});
