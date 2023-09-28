import feather from 'feather-icons';
document.addEventListener('DOMContentLoaded', () => {
    feather.replace();
    initActionButtons();
})

function initActionButtons() {
    let actionButtons = document.querySelectorAll('button.btn.action');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            setTimeout(() => {
                feather.replace();
                initActionButtons();
            }, 1000);
        })
    })
}
