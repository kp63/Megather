addEventListener('DOMContentLoaded', () => {
    let elements = document.querySelectorAll('img[data-avatar]');
    for (let i = 0; i < elements.length; i++) {
        elements[i].onerror = function () {
            this.src = 'http://localhost:8000/assets/img/avatar/default.png'
        }
    }
})
