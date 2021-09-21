import EditorJS from '@editorjs/editorjs';

//Tools
import Header from '@editorjs/header';
import Table from '@editorjs/table';
import ImageTool from '@editorjs/image';

//Custom
import QuoteTitlePage from './quote-builder/quote-title-page';
import CustomImage from './quote-builder/custom-image';

const quoteBuilderInit = document.getElementById('js-quote-builder');

if ( typeof(quoteBuilderInit) != 'undefined' && quoteBuilderInit != null ) {

    const quoteContentInput = document.querySelector('.js-quote-builder-input');
    const quoteContent = (quoteContentInput !== null && quoteContentInput.value) ? JSON.parse(quoteContentInput.value) : '';

    const quoteBuilder = new EditorJS({

        holder: 'js-quote-builder',
        autofocus: true,
        placeholder: 'Add Quote Content...',

        /**
         * Common Inline Toolbar settings
         * - if true (or not specified), the order from 'tool' property will be used (default)
         * - if an array of tool names, this order will be used
         */
        inlineToolbar: ['link', 'marker', 'bold', 'italic'],
        inlineToolbar: true,

        /**
         * Tools list
         */
        tools: {
            header: {
                class: Header,
                config: {
                    placeholder: 'Enter heading...',
                    levels: [1, 2, 3],
                    defaultLevel: 1
                }
            },
            table: {
                class: Table,
                inlineToolbar: true,
                config: {
                    rows: 2,
                    cols: 3,
                },
            },
            image: {
                class: ImageTool,
                config: {
                    endpoints: {
                        byFile: 'http://127.0.0.1:8000/api/upload/file',
                        // byUrl: 'http://127.0.0.1:8000/api/upload/url'
                    }
                }
            },
            //Bespoke
            quote_title_page: QuoteTitlePage,
            custom_image: CustomImage,
        },
        data: quoteContent
    });

    /**
     * Save quote page builder content into hidden input to post.
     * @type {Element}
     */
    const quoteSaveButton = document.querySelector('.js-quote-save-submit');
    if (quoteSaveButton) {
        quoteSaveButton.addEventListener('click', event => {
            event.preventDefault();

            quoteBuilder.save().then((outputData) => {

                console.log(outputData);

                const quoteBuilderInput = document.querySelector('.js-quote-builder-input')

                quoteBuilderInput.value = JSON.stringify(Object.assign({}, outputData));
                quoteBuilderInput.closest('form').submit();

            }).catch((error) => {
                console.log('Saving failed: ', error)
            });

        });
    }

    /**
     * Debug save button.
     * @type {Element}
     */
    const button = document.querySelector('.js-editor-save');
    if (button) {
        button.addEventListener('click', event => {
            quoteBuilder.save().then((outputData) => {
                console.log('Article data: ', outputData)
            }).catch((error) => {
                console.log('Saving failed: ', error)
            });
        });
    }

}


