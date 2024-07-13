function showCustomAlert(message, type = 'info') {
    const alertClass = `custom-alert-${type}`;
    const alertDiv = document.createElement('div');
    alertDiv.className = `custom-alert ${alertClass}`;
    alertDiv.textContent = message;
    document.body.appendChild(alertDiv);
    alertDiv.style.position = 'fixed';
    alertDiv.style.bottom = '10px';
    alertDiv.style.right = '10px';
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

let alertIndex = 0;

function showCustomAlertWithLoader(message, type = 'info') {
    const alertClass = `custom-alert-${type}`;
    const alertDiv = document.createElement('div');
    const loaderDiv = document.createElement('div');

    alertIndex++;

    alertDiv.className = `custom-alert ${alertClass}`;
    loaderDiv.className = 'custom-loader';

    const icon = document.createElement('i');
    
    switch(type) {
        case 'warning':
        case 'danger':
            icon.className = 'fa-solid fa-triangle-exclamation';
            break;
        case 'info':
            icon.className = 'fa-solid fa-circle-info';
            break;
        case 'success':
            icon.className = 'fa-solid fa-square-check';
            break;
        default:
            icon.className = '';
    }

    if (icon.className) {
        alertDiv.appendChild(icon);
        alertDiv.appendChild(document.createTextNode(' '));
    }

    alertDiv.appendChild(document.createTextNode(message));
    document.body.appendChild(alertDiv);
    alertDiv.appendChild(loaderDiv);

    const verticalPosition = 10 + alertIndex * 90;
    alertDiv.style.position = 'fixed';
    alertDiv.style.bottom = `${verticalPosition}px`; 
    alertDiv.style.right = '10px';
    alertDiv.style.zIndex = `${5000 + alertIndex}`; 

    setTimeout(() => {
        alertDiv.remove();
        alertIndex--;
    }, 3000);

    setTimeout(() => {
        loaderDiv.remove();
    }, 3000);
}


window.addEventListener('success', function(event) {
    const message = event.detail[0].message;
    showCustomAlertWithLoader(message, 'success');
});

window.addEventListener('danger', function(event) {
    const message = event.detail[0].message;
    showCustomAlertWithLoader(message, 'danger');
});

window.addEventListener('warning', function(event) {
    const message = event.detail[0].message;
    showCustomAlertWithLoader(message, 'warning');
});

window.addEventListener('info', function(event) {
    const message = event.detail[0].message;
    showCustomAlertWithLoader(message, 'info');
});



