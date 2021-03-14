// DOM
const qs = selector => document.querySelector(selector)
const qsa = selector => document.querySelectorAll(selector)
const html = qs('html')
const addNewBtn = qs('#addNewBtn')
const searchBox = qs('#searchInput')
const date = qsa('.date')
const amount = qsa('.amount')
const receiver = qsa('.receiver')
const description = qsa('.description')

// Event Listeners
addNewBtn.onclick = () => { window.location.href = 'newVoucher' }
qs('#searchIcon').addEventListener('click', () => searchInput.focus())
html.addEventListener('keydown', event => {
	if (event.key == 's' && event.altKey) { searchBox.focus() }
	if (event.key == 'n' && event.altKey) { addNewBtn.click() }
})
const edit = id => window.location.href = `editVoucher/${id}`
const del = id => {
	let deleteConfirm = confirm('Are you sure you want to delete ?')
	if (deleteConfirm) {
		let xmlhttp = new XMLHttpRequest()
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
            	alert(this.responseText)
            	window.location.reload()
            }
        }
        xmlhttp.open("POST", "delete", true)
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        xmlhttp.send(`id=${id}&tableName=vouchers`)
	}
}
searchBox.addEventListener('input', () => {
	let query = searchBox.value.toLowerCase().trim()
	for (var i = 0; i < date.length; i++) {
		if ((date[i].innerText.toLowerCase().indexOf(query) == -1)) {
			date[i].parentElement.style.display = 'none'
			if (amount[i].innerText.toLowerCase().indexOf(query) == -1) {
				amount[i].parentElement.style.display = 'none'
				if (receiver[i].innerText.toLowerCase().indexOf(query) == -1) {
					receiver[i].parentElement.style.display = 'none'
					if (description[i].innerText.toLowerCase().indexOf(query) == -1) {
						description[i].parentElement.style.display = 'none'
					}
					else{
						description[i].parentElement.style.display = 'table-row'
					}
				}
				else{
					receiver[i].parentElement.style.display = 'table-row'
				}
			}
			else{
				amount[i].parentElement.style.display = 'table-row'
			}
		}
		else{
			date[i].parentElement.style.display = 'table-row'
		}
	}
})