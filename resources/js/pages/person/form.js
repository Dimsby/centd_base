Vue.component('person-name-source', require('../../components/person/NameSource.vue').default);

window.mix = {
    data:{
        success: false,
        formerrors: [],
        found_date_type: document.getElementById('found_date_type').value,
        burial_date_type: document.getElementById('burial_date_type').value
    },
    methods : { onSubmit() {
            let myForm = document.getElementById('personForm');
            let formData = new FormData(myForm);

            let keys = Object.keys(this.$refs.namesource.uploads);
            keys.forEach(rowIndex => {
                let files = this.$refs.namesource.uploads[rowIndex];
                Object.keys(files).forEach(fileIndex => {
                    formData.append('sourceUploadFiles[' + rowIndex + '][]', files[fileIndex]);
               })
            });

            formData.append('sourceDeletes', JSON.stringify(this.$refs.namesource.deletes));
            formData.append('source', JSON.stringify(this.$refs.namesource.rows));

            axios.post(myForm.getAttribute('action'), formData).then(response => {
                this.formerrors = [];
                this.success = true;
                if (response.data.success && response.data.redirect)
                {
                    location.replace(response.data.redirect);
                }
            }).catch((error) => {
                this.formerrors = error.response.data.errors;
                this.success = false;
            }).finally(() => {
                this.isLoading = false;
            });
        }
    },
    mounted() {
    }
};
