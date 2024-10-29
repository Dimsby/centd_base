
document.addEventListener("DOMContentLoaded", function(event) {

    let elements;

    elements = document.querySelectorAll('[name=lnkDelete]');
    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', function (event) {
            let tr = event.target.closest('tr');
            if (!confirm('Подтвердите удаление'))
                return true;
            axios.delete('person/' + tr.dataset.id).then(response => {
                tr.remove();
            }).catch((error) => {
                console.log(error);
            });
        }, false);
    }

    elements = document.querySelectorAll('[name=isPublished]');
    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', function (event) {   
            let tr = event.target.closest('tr'); 
            axios.post('/base/public/person/updPub/' + tr.dataset.id, {'is_published': this.checked?1:0});
        }, false);
    }       

    document.getElementById('year').addEventListener('change', function(){
        this.form.submit();
    }, false);

    document.getElementById('foundat').addEventListener('change', function(){
        this.form.submit();
    }, false);  

    if (document.getElementById('user')) {
        document.getElementById('user').addEventListener('change', function(){
            this.form.submit();
        }, false);
    }

    if (document.getElementById('filter_is_published')) {
        document.getElementById('filter_is_published').addEventListener('change', function(){
            this.form.submit();
        }, false);
    }    

        
})
