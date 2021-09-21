class CustomImage {

    static get toolbox() {
        return {
            title: 'Custom Image',
            icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 150V79c0-19-15-34-34-34H79c-19 0-34 15-34 34v42l67-44 81 72 56-29 42 30zm0 52l-43-30-56 30-81-67-66 39v23c0 19 15 34 34 34h178c17 0 31-13 34-29zM79 0h178c44 0 79 35 79 79v118c0 44-35 79-79 79H79c-44 0-79-35-79-79V79C0 35 35 0 79 0z"/></svg>'
        };
    }

    constructor({data, api}){
        this.api = api;
        this.data = data;
        this.fileInput = '';
        this.fileUrl ='';
    }

    render(){

        const wrapper = document.createElement('div');
        const title_label = document.createElement('label');
        const file_input = document.createElement('input');

        wrapper.classList.add('block-custom-image');
        wrapper.appendChild(title_label);
        wrapper.appendChild(file_input);

        title_label.innerText = 'Upload Image*';
        title_label.classList.add(
            'block',
            'font-medium',
            'text-sm',
            'text-gray-700'
        );

        file_input.setAttribute('id', 'image');
        file_input.setAttribute('name', 'image');
        file_input.setAttribute('type', 'file');
        //file_input.value = this.data && this.data.image ? this.data.image : '';
        file_input.classList.add(
            'rounded-md',
            'shadow-sm',
            'border-gray-300',
            'outline-none',
            'focus:border-indigo-300',
            'focus:ring',
            'focus:ring-indigo-200',
            'focus:ring-opacity-50',
            'block',
            'mt-1',
            'w-full',
            'p-2'
        );

        //Add Image
        if (this.data && this.data.image) {
            const image = document.createElement('img');
            image.setAttribute('src', this.data.image);
            wrapper.appendChild(image);
        }

        this.fileInput = file_input;

        this.initEventListeners();

        return wrapper;

    }

    save(blockContent){

        return {
            image: this.fileUrl
        }
    }

    initEventListeners() {

        this.api.listeners.on(this.fileInput, 'change', (e) => {

            const file = e.target.files[0];

            let data = new FormData();
            data.append('image', file);

            axios.post('/api/upload/file', data,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {

                this.fileUrl = response.data.file.url

                const image = document.createElement('img');
                image.setAttribute('src', this.fileUrl);
                this.fileInput.closest('div').appendChild(image);

                //@TODO - Delete previous uploaded image

            })
            .catch(error => {
                console.log(error);
            });

        }, false);

    }

}
export default CustomImage;
