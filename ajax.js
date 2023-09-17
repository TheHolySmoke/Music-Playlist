const search = document.querySelector('#search')
const table = document.querySelector('table')

async function refresh(){
    let resp  = await fetch('search.php?search=' + search.value)
    let data  = await resp.json()
    
    table.innerHTML = "";
    for(const key in data){
        
        let tr = document.createElement('tr')

        for(const field in data[key]){
            let td = document.createElement('td')
            td.innerText = data[key][field]
            tr.appendChild(td)
        }

        table.appendChild(tr)
        
    }
}

search.addEventListener('input', refresh)
refresh()
