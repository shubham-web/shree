// DOM 
const qs = selector => document.querySelector(selector)
const html = qs('html')
const addNewBtn = qs('#addNewBtn')
const reportBtn = qs('#reportBtn')
const searchBox = qs('#searchInput')
const companyName = document.querySelectorAll('.cName')
const gstin = document.querySelectorAll('.gstin')
// Event Listeners

addNewBtn.onclick = () => { window.location.href = 'newCompany' }
reportBtn.onclick = () => { window.open('allCompanies') }
qs('#searchIcon').addEventListener('click', () => searchInput.focus())
html.addEventListener('keydown', event => {
	if (event.key == 's' && event.altKey) {
		searchBox.focus()
	}
	if (event.key == 'n' && event.altKey) {
		addNewBtn.click()
	}
})

const viewCompany = cId => {
	viewPopup.click()
	qs('#companyDetails').innerHTML = '<section id="logoSection"><img src="logo" id="logoImg" /><img src="gear" id="gearImg" /></section>'
	fetch(`fetchCompany/${cId}`)
	.then(r => r.text())
	.then(txt => {
		qs('#companyDetails').innerHTML = txt
	})
}
const dismissBtn = qs('#dismiss')
const viewPopup = qs('#view')
const popupBox = qs('#popupBox')
const content = qs('#content')
viewPopup.addEventListener('click', () => {
	popupBox.style.display = 'inline-block'
	setTimeout(() => { popupBox.style.opacity = 1; }, 200)
	setTimeout(() => { content.style.transform = 'translate(-50%,-50%) scale(1)' }, 300)
})
dismissBtn.addEventListener('click', () => {
	content.style.transform = 'translate(-50%,-50%) scale(0)'
	setTimeout(() => {
		popupBox.style.opacity = 0
		popupBox.style.display ='none'
	}, 200)
})
window.addEventListener('click', event => {
	if (event.target == popupBox) dismissBtn.click()
})
window.addEventListener('keydown', event => {
	if (event.key == 'Escape') dismissBtn.click()
})


const editCompany = cId => {
	window.location.href = `editCompany/${cId}`
}
const deleteCompany = cId => {
	let deleteConfirm = confirm('Are you sure you want to delete ?')
	if (deleteConfirm) {
		let xmlhttp = new XMLHttpRequest()
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
            	alert(this.responseText)
            	window.location.reload()
            }
        };
        xmlhttp.open("POST", "delete", true)
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
        xmlhttp.send(`id=${cId}&tableName=companies`)
	}
}
searchBox.addEventListener('input', () => {
	let query = searchBox.value.toLowerCase().trim()
	for (var i = 0; i < companyName.length; i++) {
		if ((companyName[i].innerText.toLowerCase().indexOf(query) == -1)) {
				companyName[i].parentElement.style.display = 'none'
				if (gstin[i].innerText.toLowerCase().indexOf(query) == -1) {
						gstin[i].parentElement.style.display = 'none'
				}
				else{
					gstin[i].parentElement.style.display = 'table-row'
				}
		}
		else{
			companyName[i].parentElement.style.display = 'table-row'
		}
	}
})