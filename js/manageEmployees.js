// DOM 
const qs = selector => document.querySelector(selector)
const html = qs('html')
const addNewBtn = qs('#addNewBtn')
const manageSalaryBtn = qs('#reportBtn')
const manageAdvanceBtn = qs('#reportBtn2')
const searchBox = qs('#searchInput')
const name = document.querySelectorAll('.name')
const qualification = document.querySelectorAll('.qualification')
const contact = document.querySelectorAll('.contact')
const date = document.querySelectorAll('.date')
// Event Listeners
qs('#searchIcon').addEventListener('click', () => searchInput.focus())
addNewBtn.onclick = () => { window.location.href = 'newEmployee' }
manageSalaryBtn.onclick = () => { window.location.href = 'manageSalary' }
manageAdvanceBtn.onclick = () => { window.location.href = 'manageAdvance' }

html.addEventListener('keydown', event => {
	if (event.key == 's' && event.altKey) { searchBox.focus() }
	else if (event.key == 'n' && event.altKey) { addNewBtn.click() }
})

const view = id => {
	viewPopup.click()
	qs('#employeeDetails').innerHTML = '<section id="logoSection"><img src="logo" id="logoImg" /><img src="gear" id="gearImg" /></section>'
	let xmlhttp = new XMLHttpRequest()
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			qs('#employeeDetails').innerHTML = this.responseText
		}
	}
	xmlhttp.open("GET", `fetchEmployee/${id}`, true)
	xmlhttp.send()
}
const edit = id => window.location.href = `editEmployee/${id}` 
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
        xmlhttp.send(`id=${id}&tableName=employees`)
	}
}
let dismissBtn = qs('#dismiss')
let viewPopup = qs('#view')
let popupBox = qs('#popupBox')
let content = qs('#content')
viewPopup.onclick = () => {
	popupBox.style.display = 'inline-block'
	setTimeout(() => { popupBox.style.opacity = 1; }, 200)
	setTimeout(() => { content.style.transform = 'translate(-50%,-50%) scale(1)' }, 300)
}
dismissBtn.onclick = event => {
	content.style.transform = 'translate(-50%,-50%) scale(0)'
	setTimeout(() => {
		popupBox.style.opacity = 0;
		popupBox.style.display = 'none'
	}, 200)
}
window.onclick = event => { if (event.target == popupBox) dismissBtn.click() }
window.onkeydown = event => { if (event.key == 'Escape') dismissBtn.click() }
searchBox.addEventListener('input', () => {
	let query = searchBox.value.toLowerCase().trim()
	for (var i = 0; i < name.length; i++) {
		if ((name[i].innerText.toLowerCase().indexOf(query) == -1)) {
			name[i].parentElement.style.display = 'none'
			if (qualification[i].innerText.toLowerCase().indexOf(query) == -1) {
				qualification[i].parentElement.style.display = 'none'
				if (contact[i].innerText.toLowerCase().indexOf(query) == -1) {
					contact[i].parentElement.style.display = 'none'
					if (date[i].innerText.toLowerCase().indexOf(query) == -1) {
						date[i].parentElement.style.display = 'none'
					}
					else{
						date[i].parentElement.style.display = 'table-row'
					}
				}
				else{
					contact[i].parentElement.style.display = 'table-row'
				}
			}
			else{
				qualification[i].parentElement.style.display = 'table-row'
			}
		}
		else{
			name[i].parentElement.style.display = 'table-row'
		}
	}
})