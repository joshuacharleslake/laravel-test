class QuoteTitlePage {

    static get toolbox() {
        return {
            title: 'Quote Title Page',
            icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 150V79c0-19-15-34-34-34H79c-19 0-34 15-34 34v42l67-44 81 72 56-29 42 30zm0 52l-43-30-56 30-81-67-66 39v23c0 19 15 34 34 34h178c17 0 31-13 34-29zM79 0h178c44 0 79 35 79 79v118c0 44-35 79-79 79H79c-44 0-79-35-79-79V79C0 35 35 0 79 0z"/></svg>'
        };
    }

    constructor({data}){
        this.data = data;
    }

    render(){

        const wrapper = document.createElement('div');
        const title_label = document.createElement('label');
        const title_input = document.createElement('input');

        wrapper.classList.add('block-quote-title-page');
        wrapper.appendChild(title_label);
        wrapper.appendChild(title_input);

        title_label.innerText = 'Enter title*';
        title_label.classList.add(
            'block',
            'font-medium',
            'text-sm',
            'text-gray-700'
        );

        console.log(this.data);

        title_input.placeholder = 'Enter title...';
        title_input.setAttribute('id', 'title');
        title_input.setAttribute('name', 'title');
        title_input.value = this.data && this.data.title ? this.data.title : '';
        title_input.classList.add(
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

        return wrapper;

    }

    save(blockContent){

        const input = blockContent.querySelector('input[name=title]');

        return {
            title: input.value
        }
    }
}

export default QuoteTitlePage;
