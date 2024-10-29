
let elements;

elements = document.querySelectorAll('[name=lnkDelete]');
for (let i=0; i<elements.length; i++) {
    elements[i].addEventListener('click', function (event) {
        let tr = event.target.closest('tr');
        if (!confirm('Подтвердите удаление'))
            return true;
        axios.delete('user/'+tr.dataset.id).then(response => {
            tr.remove();
        }).catch((error) => {
            console.log(error);
        });
    }, false);
}

elements = document.querySelectorAll('[name=checkAdmin]');
for (let i=0; i<elements.length; i++) {
    elements[i].addEventListener('click', function (event) {
        let tr = event.target.closest('tr');
        axios.put('user/'+tr.dataset.id, {'is_admin': event.target.checked });
    }, false);
}
