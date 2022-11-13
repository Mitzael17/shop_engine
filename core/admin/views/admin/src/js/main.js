import { createElement } from "./modules/functions.js";
import { makeSearchFields } from "./modules/baseFunctionForm.js";
import { MiDropList_DE } from "./modules/MiDropList-DE.js";
import { cardRotate } from "./modules/cardRotate.js";
import { MiCalendar } from "./modules/MiCalendar.js";
import { MiTabs } from "./modules/MiTabs.js";
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);



let socket;

try {
    socket = new WebSocket(CHAT_SOCKET);
    socket.addEventListener('message', function(event) {
        
        let data = JSON.parse(event.data);

        if(!data.message || data.recipient !== USER) return false;

        let messages = document.querySelector('.icon-header.message').querySelector('.number-messages');
        messages.style.display = 'flex';
        messages.innerHTML = +messages.innerHTML + 1;
        

    })

    socket.onerror = function(error) {
        console.log('server is not reachable');
    }
    
} catch(err) {
    console.log('server is failed');
}

function createPopup(message, type = 'message', callback = false) {

    const popup = createElement('div', { 
        classes: ['popup']
    });
    
    const message_block = createElement('div', { 
        classes: ['popup__message'],
        text: message
    });

    popup.append(message_block);

    if(type === 'question') {

        const button_yes = createElement('button', {
            classes: ['popup__button'],
            text: 'yes',
            callback: function(element) {
                element.dataset.answer = 'yes';
            }
        })

        const button_no = createElement('button', {
            classes: ['popup__button'],
            text: 'no',
            callback: function(element) {
                element.dataset.answer = 'no';
            }
        })

        const button_container = createElement('div', {
            classes: ['popup__block'],
            callback: (element) => {

                element.append(button_yes);
                element.append(button_no);

            }
        })

        popup.append(button_container);

    } else {

        const close_icon = createElement('div', {
            classes: ['popup__close'],
            callback: (element) => {

                element.addEventListener('click', ()=> {
                    popup.remove();
                }, {once:true})

            }
        })

        popup.append(close_icon);

        document.body.addEventListener('click', ()=> {
            popup.remove();
        }, {once:true})

    }

    document.body.append(popup);

    popup.addEventListener('click', (event) => {
        event.stopPropagation();
        event.preventDefault();
        return false;
    })

    callback && callback(popup);

}

function contenteditableKey(event) {

    const collection_keys = new Set();

    let target = this;

    let last_message = target.lastElementChild ? target.lastElementChild : null;

    target.addEventListener('keydown', keyDown );
    target.addEventListener('keyup', keyUp );
    target.addEventListener('blur', () => {

        target.removeEventListener('keydown', keyDown);
        target.removeEventListener('keyup', keyUp);

        if(target.innerHTML === '<div></div>') target.innerHTML = null;

    }, {once:true});

    function keyDown(event) {

        if(event.key === 'Enter') event.preventDefault();

        if(event.key === 'Control') collection_keys.add(event.key);
        
        if(event.key === 'Enter' && collection_keys.has('Control')) {

            const target_value = target.innerHTML.trim();

            if(!target_value.length) return false;
            if(!target.querySelector('div')) last_message = null;

            const div = getNearestDiv(target);

            if( !div.classList.contains('chat__input') && div !== target.lastElementChild) {

                if(!div.innerHTML) return false;

                const next_div = createElement('div', {
                    text: '<br>'
                })

                div.insertAdjacentElement('afterend', next_div);
                relocateCursor(next_div);

                return false;

            }

            if(last_message && (last_message.innerHTML === '<br>' || !last_message.innerHTML.length) ) return false;

            last_message = createElement('div', {
                text: '<br>',
            })

            target.append(last_message);
            relocateCursor(last_message)

        } else if((event.key === 'Enter')) {

            const form = target.closest('form');

            if(form) form.dispatchEvent(new Event('submit'));

        }
    }

    function keyUp(event) {

        collection_keys.delete(event.key);

    }

    function getNearestDiv(target) {

        let selection = document.getSelection()
        let range = new Range

        range.setStart(target, 0)
        range.setEnd(selection.anchorNode, selection.anchorOffset)

        return selection.anchorNode.parentElement;

    }

    function relocateCursor(block) {

        let range, selection;

        range = document.createRange();
        range.selectNodeContents(block);
        range.collapse(false);
        selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);

    }

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const search_form = document.querySelector(('#search'));

if(search_form) {

    makeSearchFields([search_form], {
        selector: 'input',
        extractCallback: async function({query}) {

            const limit = 10;

            let result = await fetch(SEARCH_URL, {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    query: query,
                    limit: limit
                }),
            });

            if(result.ok) result = await result.json();

            return result;

        },
        buildCallback: function() {

            return createElement('div');

        },
        chooseCallback: function({target, keyBoard}) {
            
            if(!keyBoard) window.location.href = target.dataset.href;

            if(keyBoard !== 'Enter') return;

            window.location.href = target.dataset.href;

        },
        fillContentCallback: function({hint, data}) {

            hint.innerHTML = data.value;
            hint.dataset.href = data.refer;

        },
        

    });

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const search_inputs = document.querySelectorAll('.search-input');

if(search_inputs) {

    let forms = new Set();

    search_inputs.forEach( input => {

        forms.add(input.closest('form'));

    })

    forms = Array.from(forms);

    makeSearchFields(forms, {
        selector: '.search-input', 
        extractCallback: async function({query, input}) {

            const limit = 10;

            const table = input.dataset.table;
            
            const url = SEARCH_URL + '/' + table;

            let result = await fetch(url, {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    query: query,
                    limit: limit
                }),
            });

            if(result.ok) result = await result.json();

            return result;
        },
        buildCallback: function() {

            return createElement('div');

        },
        fillContentCallback: function({hint, data}) {

            data.value = data.value.substring(0, data.value.indexOf('(') - 1)

            hint.innerHTML = data.value;
            hint.dataset.value = data.id;

        },
        chooseCallback: function({target, keyBoard}) {


            if(keyBoard && keyBoard !== 'Enter') return false;

            const search_block = target.closest('.search-block');
            const hidden_input = search_block.querySelector('input[type="hidden"]');
            const input = search_block.querySelector('.search-input');

            hidden_input.value = target.dataset.value;
            input.value = target.innerHTML;


        }

    })

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

if(typeof ANSWER !== 'undefined') createPopup(ANSWER);

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const div_inputs = document.querySelectorAll('div[contenteditable]');

if(div_inputs) {

    div_inputs.forEach(input => input.addEventListener('focus', contenteditableKey));
    
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const nav_list = document.querySelector('.spoiler');

if(nav_list) {

    new MiDropList_DE('.nav-block.spoiler', '.spoiler-container', false, {
        animation: 'growing',
        event: 'click',
        delay: '0',
        duration: '500',
        timingFunction: 'ease',
        closeOtherLists: false,
    })

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const header_list = document.querySelector('.header-list');

if(header_list) {

    new MiDropList_DE('.header-refer-list', '.header-list', false, {
        animation: 'growing',
        event: 'click',
        delay: '0',
        duration: '500',
        timingFunction: 'ease',
        closeOtherLists: false
    })

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const card3D = document.querySelectorAll('.item-3d');

if(card3D) {
    cardRotate(card3D);
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const foreign_keys_lists = document.querySelectorAll(".foreignKeysLists");

if(foreign_keys_lists) {
    
    const list_settings = new MiDropList_DE('.foreignKeysLists-area', '.foreignKeysLists', false, {

        animation: 'growing',
        event: 'click',
        delay: '0',
        duration: '500',
        timingFunction: 'ease',
        closeOtherLists: false,

    });

    const foreign_keys_areas = document.querySelectorAll('.foreignKeysLists-area');

    foreign_keys_areas.forEach( area => {

        area.querySelector('.foreignKeysLists').addEventListener('click', selectValue);

    });

    function selectValue(event) {
        
        const target = event.target.closest('.foreignKeyValue');

        if(!target) return false;

        const area = target.closest('.foreignKeysLists-area');
        const input = area.querySelector('input');
        const block_selected_value = area.querySelector('.selected-value');
        const active_target = area.querySelector('.selected');

        input.value = target.dataset.id;
        block_selected_value.innerHTML = target.innerHTML;

        if(active_target) active_target.classList.remove('selected');   

        target.classList.add('selected');

    };

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const many_to_many_lists = document.querySelectorAll('.manyToMany-list');

if(many_to_many_lists) {

    const list_settings = new MiDropList_DE('.manyToMany-list-area', '.manyToMany-list', false, {
      
        animation: 'growing',
        event: 'click',
        delay: '0',
        duration: '500',
        timingFunction: 'ease',
        
    })

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

if(document.forms) {

    [...document.forms].forEach( form => {

        if(form.classList.contains('no_default_form')) return false;

        formInit(form);

    });

    function formInit(form) {

        let files = [];
        let deleted_files = []; 

        form.addEventListener('submit', function(event) {

            event.preventDefault();

            if(!validation(form)) return false;

            const data = new FormData(this);
            const file_inputs = this.querySelectorAll('input[type="file"]');

            file_inputs.forEach(input => {

                const name = input.name.replace(/\[\]$/, '');

                if(files[name]) {

                    data.delete(input.name);
                   
                    if(Array.isArray(files[name])) {

                        files[name].forEach((file, index) => {

                            if(!file) return false;
    
                            data.append(`${name}[${index}]`, file);
    
                        });

                    } else {

                        data.append(name, files[name]);

                    }




                } else {
                    data.delete(input.name);
                };

                if(deleted_files[name]) {
        
                    deleted_files[name].forEach( (file, index) => {

                        data.append(`deletedFiles[${name}][${index}]]`, file);

                    });
                    
                };

            });

            fetch(this.action, {
                method: 'post',
                body: data,
                contentType: 'multipart/form-data;charset=UTF-8',
                acceptCharset: "UTF-8",
            }).then( (res) => {

                return res.json();

            })
            .then( (result) => {

                createPopup(result.message)

                files = [];
                deleted_files = []; 

                if(result) {

                    if(result.redirect) {
                        window.location.href = result.redirect;
                    }

                    if(result.images) {

                        for(const [key, value] of Object.entries(result.images)) {

                            const container_images = form.querySelector(`#${key}`).closest('.img-container');
                            let images = container_images.querySelectorAll('img');

                            images = [...images].filter( img => img.src.match(/^data:image\//) );

                            images.forEach( (img, index) => {

                                img.src = value[index];
                                img.removeAttribute('data-id');

                            });

                        }

                    }
                    
                }
                 
            })
            .catch(err => alert(err))

            return false;

        })

        const main_images = form.querySelectorAll('.img-container');

        if(main_images) {

            main_images.forEach( container_images => {
                
                const del_icons = container_images.querySelectorAll('.icon-delete');
                const container_del_button = container_images.closest('.edit-block-container-img');
                const input = container_images.querySelector('input');

                if(del_icons) {

                    const name = input.name.replace(/\[\]$/, '');

                    del_icons.forEach( icon => {

                        icon.addEventListener('transitionend', event => {

                            event.stopPropagation()

                        });

                        icon.addEventListener('click', function(event) {

                            deleteImg(event, name);
                            
                        });

                    })
                };

                if(container_del_button) {

                    const del_button = container_del_button.querySelector('.del-button');

                    if(del_button) {

                        const name = input.name;

                        del_button.addEventListener('transitionend', event => {

                            event.stopPropagation();

                        });

                        del_button.addEventListener('click', function(event) {

                            deleteImg(event, name);

                        });

                    }

                };

                input.addEventListener('change', uploadImage);
                dragAndDrop(container_images);

            });

        };
        
        function dragAndDrop(container_images) {

            let counter = 0;
            const events = ['dragenter', 'dragover', 'dragleave', 'drop'];

            events.forEach( (event, index) => {
                
                container_images.addEventListener(event, function(event) {

                    event.preventDefault();
                    event.stopPropagation();
                    
                    if(index === 0) {

                        container_images.classList.add('activeDrag');
                        counter++;

                    };

                    if(index === 2 || index === 3) {

                        counter--;

                        if(counter === 0 || index === 3) {

                            container_images.classList.remove('activeDrag');

                        };
                        
                        if(index === 3) {

                            const input = container_images.querySelector('input');
                            
                            input.files = event.dataTransfer.files;

                            input.dispatchEvent(new Event('change'));

                        };

                    };

                });

            });

        }

        function uploadImage(event) {

            const name = event.target.getAttribute('name').replace(/\[\]$/, '');

            [...this.files].forEach( file => {

                const reader = new FileReader();

                reader.readAsDataURL(file);
    
                reader.onload = (event) => {
    
                    const container_images = this.closest('.img-container');

                    if(this.hasAttribute('multiple')) {
                        
                        if(!files[name]) files[name] = [];

                        files[name].push(file);

                        const image = createElement('div', {
                            classes: ['img-block'],
                            text: `<img data-id="${files[name].length - 1}" src="${event.target.result}"><div class="${'icon-delete'}"><span></span><span></span></div>`,
                        })

                        container_images.append(image);

                        const icon_delete = image.querySelector('.icon-delete');

                        icon_delete.addEventListener('transitionend', event => {

                            event.stopPropagation()

                        });

                        icon_delete.addEventListener('click', function(event) {

                            deleteImg(event, name);

                        });

                    } else {

                        files[name] = file;

                        container_images.querySelector('img').src = event.target.result;

                    };
    
                }

            });

        }

        function deleteImg(event, name) {
            
            let container = event.target.closest('.img-block');

            let delete_container = true;

            if(!container) {

                delete_container = false;

                container = event.target.closest('.edit-block-container-img');
                
            }

            const img = container.querySelector('img');

            if(!img.src) return false;

            if(img.dataset.id) {

                files[name][img.dataset.id] = null;

            } else {

                if(!deleted_files[name]) deleted_files[name] = [];

                deleted_files[name].push(img.src);

            }
            
            if(delete_container) {

                container.remove();

            } else {

                img.src = '';

            };

        }

    }

    function validation(form) {

        let resitrctions = form.querySelectorAll('input[data-maxvalue]');

        if(resitrctions) {

            resitrctions.forEach(input => {

                if(input.value === '' || input.value.match(/\D/)) {
                    input.value = input.dataset.maxvalue;
                }

                if(+input.dataset.maxvalue < +input.value) input.value = input.dataset.maxvalue;

            })

        };

        return true;

    }

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const password_inputs = document.querySelectorAll('.block-password');

if(password_inputs) {

    password_inputs.forEach( element => {

        const icon = element.querySelector('.icon-show');

        if(!icon) return false;

        icon.addEventListener('click', () => {
            
            const input = element.querySelector('input[type="password"]');

            if(input) {

                input.type = 'text';

            } else {

                element.querySelector('input').type = 'password';

            }

        });

    })


}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const calendars = document.querySelectorAll('.calendar');

if(calendars) {

    const date = new Date();

    calendars.forEach( element => {

        const input = element.querySelector('input');

        const calendar = new MiCalendar({

            parent: element,
            input: input,
            inputClickable: true,
            closeAfterChoice: true,

            range: {
                beginning: {
                    year: '2022',
                },
                end: {
                    year: date.getFullYear(),
                    month: date.getMonth() + 1,
                    day: date.getDate(),
                }
            },

            animation: {
                appearance: 'opacity',               
            }
            
        });

        document.body.addEventListener('click', (event) => {

            const input = event.target.closest('input');
            
            if(event.target.closest('.MiCalendar') || (input && input.nextElementSibling == calendar.calendar)) return false;
            
            if(event.target.closest('.MiCalendar__reachable--month')) return false;

            calendar.hide();

        });

    }) 

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const lazy_loading_log_button = document.querySelector('#loadMoreLogs');

if(lazy_loading_log_button) {

    let logs = ID_LOGS - 2;
    
    lazy_loading_log_button.addEventListener('click', () => {

        const url = lazy_loading_log_button.dataset.url + '?logs=' + logs;

        fetch(url)
        .then( res => {

            return res.json();

        })
        .then( res => {

            logs = logs - 3;
            
            if(res.length) {

                for(let log of res) {

                    const log_element = document.querySelector('.logs__log').cloneNode(true);

                    lazy_loading_log_button.insertAdjacentElement('beforebegin', log_element);

                    const avatar = log_element.querySelector('img');
                    const username = log_element.querySelector('.item-text.item-header');
                    const role = log_element.querySelector('.item-text.item-mini');
                    const date = log_element.querySelector('.logs__date');
    
                    avatar.src = log.avatar;
                    username.innerHTML = log.name;
                    role.innerHTML = log.role;
                    date.innerHTML = log.date;

                    log_element.lastElementChild.innerHTML = log.message + (log.alias ? `<a href="${log.alias}">record</a>` : '');          
                    
                };

                return true;

            }

            lazy_loading_log_button.remove();

            document.querySelector('.logs__content').insertAdjacentHTML('beforeend' ,'<div>Данных больше нет</div>');

        })
        .catch(err => alert(err));

    })

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const log_form = document.querySelector('.logs_form');

if(log_form) {

    let log_element = document.querySelector('.logs__log').cloneNode(true);
    const log_container = document.querySelector('.logs__content');

    log_form.addEventListener('submit', function(event) {

        event.preventDefault();

        const inputs =this.querySelectorAll('input');

        inputs.forEach( input => {

            if(!input.value.match(/^\d{4,4}-\d{2,2}-\d{2,2}$/)) input.value = '';

        })

        if(![...inputs].find( input => input.value.length)) return false;

        const url = this.action;

        fetch(url, {
            method: 'post',
            body: new FormData(this),

        })
        .then(res => res.json())
        .then( res => {
            
            if(res.length) {

                log_container.innerHTML = '';

                for(let log of res) {

                    log_container.append(log_element);
    
                    const avatar = log_element.querySelector('img');
                    const username = log_element.querySelector('.item-text.item-header');
                    const role = log_element.querySelector('.item-text.item-mini');
                    const date = log_element.querySelector('.logs__date');

                    avatar.src = log.avatar;
                    username.innerHTML = log.name;
                    role.innerHTML = log.role;
                    date.innerHTML = log.date;

                    log_element.lastElementChild.innerHTML = log.message + (log.alias ? `<a href="${log.alias}">record</a>` : '');
                    
                    log_element = document.querySelector('.logs__log').cloneNode(true);
                    
                }

            } else {

                document.querySelector('.logs__content').innerHTML = 'Данные остутствуют';

            }

        })
        .catch(err => alert(err));

    })
    
}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const chat = document.querySelector('.chat');

if(chat) {

    const chat_tabs = new MiTabs('.chat__users', '.chat__area', {

        contentCallback: async function() {

            const tabPageId = '?chat=' + arguments[0];
    
            const url = CHAT_ASYNC + tabPageId;
    
            let response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            });
    
            if(response.ok) {
    
                const data = await response.json();

                const chat_messages = createElement('div', {
                    classes: ['chat__messages', 'c-scroll'],
                    callback: (element) => {

                        element.dataset.date = data.oldestDate ? data.oldestDate : false;
                        element.addEventListener('scroll', lazyLoadingMessages);

                    }
                });
    
                data.messages.forEach( message => {
                    
                    let class_message = USER === message.name ? 'chat__messageText--right' : 'chat__messageText--left';
    
                    chat_messages.innerHTML += `<div class="chat__messageText item-text ${class_message}">${message.message}</div>`
    
                });

                const form = createElement('form', {
                    classes: ['chat__form', 'no_default_form'],
                    callback: (element) => {
                        element.addEventListener('submit', submitMessage);
                    }
                });
    
                const chat_input_container = createElement('div', {
                    classes: ['chat__inputContainer']
                });

                const chat_input = createElement('div', {
                    classes: ['chat__input', 'c-scroll'],
                    callback: (element) => {
                        element.setAttribute('placeholder', 'Type something...');
                        element.setAttribute('contenteditable', 'true');
                        element.addEventListener('focus', contenteditableKey);
                    }
                });

                const button = createElement('button', {
                    text: 'Send',
                    callback: (element) => {
                        element.type = 'submit';
                    }
                })


                chat_input_container.append(chat_input);
                form.append(chat_input_container);
                form.append(button);
    
                return [chat_messages, form];
    
            } else {

                alert('error');
                return false;

            }
        },

        changeTabCallback: function({block, tabPageId}) {

            const get_parameters = '?chat=' + tabPageId;
            const message_area = block.querySelector('.chat__messages');

            window.history.pushState('', '', get_parameters);

            message_area.scrollTop = message_area.scrollHeight;

        }

    });

    let chates = chat.querySelectorAll('.chat__messages'); 

    if(chates) {

        chates.forEach( chat => {

            chat.addEventListener('scroll', lazyLoadingMessages);

            chat.scrollTop = chat.scrollHeight;

        });

    }

    let chat__users = document.querySelector('.chat__users').querySelectorAll('.chat__user');

    if(chat__users) {

        chat__users.forEach( user => {

            user.addEventListener('click', () => {

                if(!user.classList.contains('chat__user--unread')) return false;

                const body = {
                    type: 'readMessage',
                    reader: USER,
                    sender: user.dataset.tab,
                };
                
                fetch(CHAT_ASYNC, {
                    method: "POST",
                    headers: {'Content-Type': 'application/json;charset=utf-8'}, 
                    body: JSON.stringify(body)
                });

                const number_unread_messages = user.querySelector('.chat__numberUnreadMessages');
                const messages = document.querySelector('.icon-header.message').querySelector('.number-messages');
                
                messages.innerHTML = messages.innerHTML - number_unread_messages.innerHTML;

                if(messages.innerHTML === '0') messages.style.display = 'none';

                number_unread_messages.innerHTML = 0;

                user.classList.remove('chat__user--unread');

            });

        })

    };

    socket.addEventListener('message' , async function(event) {

        const data = JSON.parse(event.data);

        if(!data.message) return false;

        if( !(data.sender === USER || data.recipient === USER) ) return false;

        let messages_area = '';
        let tab;

        if(data.sender === USER) {

            tab = chat.querySelector(`[data-tabbody="${data.recipient}"]`);

            if(!tab) return false;

            messages_area = tab.querySelector('.chat__messages');
        } 

        if(data.recipient === USER) {

            tab = chat.querySelector(`[data-tabbody="${data.sender}"]`);

            const sender_narrow = chat.querySelector(`[data-tab="${data.sender}"]`);

            sender_narrow.classList.add('chat__user--unread');

            const number_unread_messages = sender_narrow.querySelector('.chat__numberUnreadMessages');

            number_unread_messages.innerHTML = +number_unread_messages.innerHTML + 1;

            if(!tab) return false;

            messages_area = tab.querySelector('.chat__messages');

            if(tab.classList.contains('active')) {

                const body = {
                    type: 'readMessage',
                    reader: USER,
                    sender: data.sender
                }
                
                fetch(CHAT_ASYNC, {
                    method: "POST",
                    headers: {'Content-Type': 'application/json;charset=utf-8'}, 
                    body: JSON.stringify(body)
                });

                const messages = document.querySelector('.icon-header.message').querySelector('.number-messages');
                
                messages.innerHTML = messages.innerHTML - number_unread_messages.innerHTML;
    
                if(messages.innerHTML === '0') messages.style.display = 'none';

                number_unread_messages.innerHTML = 0;

                sender_narrow.classList.remove('chat__user--unread');

            }

        } 

        const message = createElement('div', {
            classes: ['chat__messageText', 'item-text'],
            text: data.message,
            callback: (element) => {

                if(data.sender === USER) {
                    element.classList.add('chat__messageText--right');
                } else {
                    element.classList.add('chat__messageText--left');
                }

            }
        })

        let scroll = false;

        if(tab.classList.contains('active') && messages_area.scrollTop + messages_area.offsetHeight > messages_area.scrollHeight - 30) {
            
            scroll = true;

        }

        messages_area.append(message);

        if(scroll) messages_area.scrollTop = messages_area.scrollHeight;

    }) 

    document.querySelectorAll('.chat__form').forEach( form => form.addEventListener('submit', submitMessage));

    function submitMessage(event) {

        event.preventDefault();

        const input = this.querySelector('.chat__input');    

        if(!validate(input)) return false;

        const message = {
            chat_message: input.innerHTML,
            sender: USER,
            recipient: this.closest('[data-tabbody]').dataset.tabbody,
        }

        socket.send(JSON.stringify(message));
        
        input.innerHTML = null;

        return false;

    }

    function validate(input) {

        if(input.dataset.status === 'no-validate') return false;

        let validate = true;

        let buffer = input.innerHTML;

        if(input.innerHTML.length > 500) {
            
            input.dataset.status = 'no-validate';

            input.innerHTML = 'Max quantity of symbols is 500';
    
            input.style.color = 'red';

        }

        if(!input.innerHTML.length || input.innerHTML === 'br') {

            validate = false;

            buffer = null;

            input.dataset.status = 'no-validate';

            input.innerHTML = 'The field mustn\'t be empty';
    
            input.style.color = 'red';
        }

        if(!validate) {

            input.addEventListener('focus', () => {

                input.innerHTML = buffer;

                input.style.color = '';

                input.dataset.status = 'ok';

            },{once:true});

        }

        return validate;
    }

    async function lazyLoadingMessages(event) {

        if(event.target.scrollTop > 30 || event.target.dataset.date === 'false') {

            return false

        };

        event.target.removeEventListener('scroll', lazyLoadingMessages);

        const tab = event.target.closest('[data-tabbody]');
        const url = CHAT_ASYNC + '?chat=' + tab.dataset.tabbody + '&lastDate=' + event.target.dataset.date;
        
        let data = await fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"    
            }
        });

        if(data.ok) {
            
            data = await data.json();

            event.target.dataset.date = data.oldestDate;

            if(event.target.scrollTop < 10) event.target.scrollTop = 10;

            if(data.messages) {

                data.messages.forEach( message => {
                    
                    const message_class = message.name === USER ? 'chat__messageText--right' : 'chat__messageText--left';

                    const mes = createElement('div', {
                        classes: ['chat__messageText', 'item-text', message_class],
                        text: message.message
                    })

                    event.target.prepend(mes);

                });

            }

            if(data.messages.length < 30) {

                event.target.dataset.date = false;

            } else {

                setTimeout( () => event.target.addEventListener('scroll', lazyLoadingMessages), 1000);

            }

        }
 
    }

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const admin = document.querySelector('.admins');

if(admin) {

    new MiTabs('.MiTab__menu', '.MiTab__tabs');
    
    const selected_admins = {
        active_admins: new Set(),
        blocked_admins: new Set()
    }

    const key_downs = new Set();

    const panels = document.querySelectorAll('.admins__panel');
    
    document.addEventListener('keydown', (event) => {

        if(event.key === 'Control') key_downs.add(event.key);
        
    });

    document.addEventListener('keyup', (event) => {

        key_downs.delete(event.key);

    });

    document.querySelectorAll('.admins__list').forEach( tab => {

        tab.addEventListener('click', (event) => {

            const target = event.target.closest('.admin');
    
            if(!target) return false;

            const admins = tab.querySelectorAll('.admin');

            const collection = selected_admins[target.closest('[data-tabbody]').dataset.tabbody];
            
            const admin_name = target.querySelector('.admin__name').innerHTML;
    
            target.classList.toggle('checked');
            
    
            if(key_downs.has('Control')) {
    
                if(collection.has(admin_name)) {
    
                    collection.delete(admin_name);
    
                } else {
    
                    collection.add(admin_name);
    
                }

                return;
            }
    
    
            collection.clear();
    
            if(target.classList.contains('checked')) collection.add(admin_name);
    
            admins.forEach( admin => {
    
                if(admin === target) return;
    
                admin.classList.remove('checked');
    
            })
            
            return;
    
        });

    })

    panels.forEach(panel => {

        const tab = panel.closest('[data-tabbody]');

        const collection = selected_admins[tab.dataset.tabbody];

        panel.querySelectorAll('[data-activity]').forEach( item => {

            item.addEventListener('click', () => {
                
                if(collection.size < 1) return false;
                
                if(item.dataset.activity === 'delete') {

                    
                    createPopup('Are you sure, that you want to delete the accounts?', 'question', function(popup) {

                        const buttons = popup.querySelectorAll('.popup__button');

                        buttons.forEach(button => {

                            button.onclick = () => {

                                if(button.dataset.answer === 'yes') {

                                    ajaxAdmin(item.dataset.activity, collection);

                                }

                                popup.remove();

                            }

                        })

                    });

                    return;
                }

                ajaxAdmin(item.dataset.activity, collection);
    
            })
    
        })
    
    
        const checkbox_select_all = panel.querySelector('[name="select_all"]');

    
        checkbox_select_all.addEventListener('change', () => {
    
            const admins = tab.querySelectorAll('.admin');

            if(checkbox_select_all.checked) {


                admins.forEach(admin => {
    
                    admin.classList.add('checked');

                    collection.add(admin.querySelector('.admin__name').innerHTML);
                
                })
    
                return;
            }
    
            admins.forEach( admin => {

                admin.classList.remove('checked');

            });
    
            collection.clear();
    
            return;
    
        })

    })

    async function ajaxAdmin(type, set_collection) {

        const body = {
            type: type,
            admins: [...set_collection]
        }

        const response = await fetch(AJAX_URL, {
            method: 'POST',
            body: JSON.stringify(body),
            headers: {'Content-Type': 'application/json;charset=utf-8'}
        });

        if(response.ok) {

            let admins = [...document.querySelectorAll('.admin')];

            admins = admins.filter( admin => {
                
                const name = admin.querySelector('.admin__name').innerHTML;
    
                if(body.admins.find( item => item === name)) return true;
                
                return false;

            })
    
            if(type === 'delete') {

                admins.forEach( admin => admin.remove());

                return true;

            }
    
            const tab = type === 'unblock' ? document.querySelector('[data-tabbody="active_admins"]') : document.querySelector('[data-tabbody="blocked_admins"]');
            const tabBody = tab.querySelector('.admins__list');
    
            admins.forEach( admin => {

                tabBody.append(admin);

            })

            return true;

        }

        return false;

    }

}

//--------------------------------------------------------------------------------------------------------------------------------------------------------------

const chart = document.querySelector('.chart');

if(chart) {

    const line_chart_containers = chart.querySelectorAll('.chart__graph--line');
    const bar_chart_containers = chart.querySelectorAll('.chart__graph--bar');
    const pie_chart_containers = chart.querySelectorAll('.chart__graph--pie');
    const chart_nav = chart.querySelector('.chart__nav');

    const block_from = chart_nav.querySelector('.chart__block--from');
    const block_to = chart_nav.querySelector('.chart__block--to');
    const calendar_from = block_from.querySelector('.chart__calendar');
    const calendar_to = block_to.querySelector('.chart__calendar');
    const input_from = chart_nav.querySelector('input[name="date_from"]');
    const input_to = chart_nav.querySelector('input[name="date_to"]');
    const calendar_icon_from = block_from.querySelector('.icon-calendar');
    const calendar_icon_to = block_to.querySelector('.icon-calendar');
    const date = new Date();

    new MiCalendar({

        parent: calendar_from,
        input: input_from,
        clickToShow: [calendar_icon_from],
        closeAfterChoice: true,

        range: {
            beginning: {

                year: '2021',
                month: '1',
                day: '1'

            },
            end: {

                year: date.getFullYear(),
                month: date.getMonth() + 1,
                day: date.getDate(),

            },
        },

        animation: {
            appearance: 'growing',
            duration: '400',
            timingFunction: 'ease'
        },

    });

    new MiCalendar({

        parent: calendar_to,
        input: input_to,
        clickToShow: [calendar_icon_to],
        closeAfterChoice: true,

        range: {
            beginning: {

                year: '2021',
                month: '1',
                day: '1'

            },
            end: {

                year: date.getFullYear(),
                month: date.getMonth() + 1,
                day: date.getDate(),

            },
        },

        animation: {
            appearance: 'growing',
            duration: '400',
            timingFunction: 'ease'
        },

    });

    const labels = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
      ];


      const data = {
        labels: labels,
        datasets: [{
          label: 'My First dataset',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: [0, 10, 5, 2, 20, 30, 45],
        }]
      };
    


    bar_chart_containers.forEach( chart => {

        const config = {
            type: 'bar',
            data: data,
            options: {}
          };

        const ctx = chart.querySelector('canvas').getContext('2d');

        new Chart(ctx, config);

    })

    line_chart_containers.forEach( chart => {

        const config = {
            type: 'line',
            data: data,
            options: {}
          };

        const ctx = chart.querySelector('canvas').getContext('2d');

        new Chart(ctx, config);
    })

    pie_chart_containers.forEach( chart => {
        const data = {
            labels: [
              'Red',
              'Blue',
              'Yellow'
            ],
            datasets: [{
              label: 'My First Dataset',
              data: [300, 50, 100],
              backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
              ],
              hoverOffset: 4
            }]
          };

          const config = {
            type: 'doughnut',
            data: data,
          };

        const ctx = chart.querySelector('canvas').getContext('2d');

        new Chart(ctx, config);
    })

}






