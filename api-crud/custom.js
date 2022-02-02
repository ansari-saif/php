const url = "/api.php";

async function apiFunction(url, method, data = null) {
    const response = await fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: data ? JSON.stringify(data) : null
    });
    return response.json();
}

async function save(url, data, id=null) {
    const method = id ? "PATCH" : "POST";
    id ? url = url + '?id=' + id : null;
    return apiFunction(url, method, data);
}

async function get(url,id=null) {
    id ? url = url + '?id=' + id : null;
    return apiFunction(url, "GET");
}


get(url).then(e => {
    for (let i = 0; i < e.length; i++) {
        appendData(e[i]);
    }
 });

function saveData(thisForm) {
    event.preventDefault();
    let name = document.querySelector("#name").value;
    let detail = document.querySelector("#detail").value;

    save(url, {
        name: name,
        detail: detail
    }).then(e => {
        alert("Your Data has been successfully saved");
        appendData(e);
        thisForm.reset();
    }).catch(err => {
        alert("something went wrong");
    });
}

function appendData(data) {
    let comment = '';
    if (data.comments != undefined && data.comments.length) {
        data.comments.forEach(e => {
            comment += `<li>${e}</li>`;
        })
    }

    const myHtml = `
    <div class="display" data-id="${data.id}">
            <div class="description">
                <h2>${data.name}</h2>
                <h4>${data.detail}</h4>
            </div>
            <div class="comment">
                <div class="comment_div">
                    <form class="comment_form" onsubmit="saveComment(this)">
                        <textarea class="comment" data-id="${data.id}" placeholder="Put your comments here..." name="name"></textarea>
                        <button type="submit">Submit</button>
                    </form>
                </div>
                <div class="show_comments">
                    <ul>
                        ${comment}
                    </ul>
                </div>
            </div>
        </div>`;
    document.querySelector("#namesList").innerHTML += myHtml;
}
function saveComment(elm){
    event.preventDefault();
    const commentElm = elm.querySelector('.comment');
    const comment = commentElm.value;
    const commentId = commentElm.dataset.id;
    const nameDetail = get(url,commentId);
    
    nameDetail.then(e=>{
        let commentArr = e.comments ? e.comments : [];
        commentArr.push(comment);
        save(url,{
            comments:commentArr
        },commentId).then(e2=>{
            const li = document.createElement('li');
            li.innerHTML = comment;
            elm.parentElement.nextElementSibling.firstElementChild.append(li);
            elm.reset();
        });
    })
}
