// DOM
const qs = selector => document.querySelector(selector)
const addNewBtn = qs('#addNewBtn')
const chalanNumber = document.querySelectorAll('.chalanNumber')
const companyName = document.querySelectorAll('.companyName')
const gatepassNumber = document.querySelectorAll('.gatepassNumber')
const searchBox = qs('#searchInput')
const html = qs('html')

// Event Listener
qs('#searchIcon').addEventListener('click', () => searchInput.focus())
addNewBtn.addEventListener('click', () => {
	window.location.href = 'newChalan'
})
const print = chalanNumber => window.open(`chalan/${chalanNumber}`) 
searchBox.addEventListener('input', () => {
	let query = searchBox.value.toLowerCase()
	for (var i = 0; i < companyName.length; i++) {
		if ((companyName[i].innerText.toLowerCase().indexOf(query) == -1)) {
				companyName[i].parentElement.style.display = 'none'
				if (gatepassNumber[i].innerText.toLowerCase().indexOf(query) == -1) {
					gatepassNumber[i].parentElement.style.display = 'none'
					if (chalanNumber[i].innerText.toLowerCase().indexOf(query) == -1) {
							chalanNumber[i].parentElement.style.display = 'none'
					}
					else{
						chalanNumber[i].parentElement.style.display = 'table-row'
					}
				}
				else{
					gatepassNumber[i].parentElement.style.display = 'table-row'
				}
		}
		else{
			companyName[i].parentElement.style.display = 'table-row'
		}
	}
})
html.addEventListener('keydown', event => {
	if (event.key == 's' && event.altKey) searchBox.focus()
	if (event.key == 'n' && event.altKey) addNewBtn.click() 
})
 
const view = chalanNumber => {
	viewPopup.click()
	qs('#chalanBody').innerHTML = `<section id="logoSection"><img src="logo" id="logoImg" /><img src="gear" id="gearImg" /></section>`
	fetch(`fetchChalan/${chalanNumber}`)
	.then(r => r.text())
	.then(txt => { qs('#chalanBody').innerHTML = txt })
}

const dismissBtn = qs('#dismiss')
const viewPopup = qs('#view')
const popupBox = qs('#popupBox')
const content = qs('#content')
viewPopup.addEventListener('click', () => {
	popupBox.style.display = 'inline-block'
	setTimeout(() => { popupBox.style.opacity = 1 }, 200)
	setTimeout(() => { content.style.transform = 'translate(-50%,-50%) scale(1)' }, 300)
})
dismissBtn.addEventListener('click', () => {
	content.style.transform = 'translate(-50%,-50%) scale(0)'
	setTimeout(() => {
		popupBox.style.opacity = 0;
		popupBox.style.display = 'none'
	}, 200)
})
window.addEventListener('click', event => {
	if (event.target == popupBox) dismissBtn.click() 
})
window.addEventListener('keydown', event => {
	if (event.key == 'Escape') dismissBtn.click() 
})