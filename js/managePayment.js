// DOM 
const qs = selector => document.querySelector(selector)
const html = qs('html')
const addNewBtn = qs('#addNewBtn')
const searchBox = qs('#searchInput')
const companyName = document.querySelectorAll('.cName')
const paymentDate = document.querySelectorAll('.paymentDate')
const mode = document.querySelectorAll('.mode')
const ajaxMessages = qs('#ajaxMessages')

// Event Listeners
qs('#searchIcon').addEventListener('click', () => searchInput.focus())
addNewBtn.addEventListener('click', () => {
	window.location.href = 'addPayment'
})
html.addEventListener('keydown', event => {
	if (event.key == 's' && event.altKey) searchBox.focus()
	if (event.key == 'n' && event.altKey) addNewBtn.click()
})

const showAjaxBox = message => {	
	ajaxMessages.style.backgroundColor = '#333'
	ajaxMessages.innerHTML = message
	ajaxMessages.className = 'show'
}

const hideAjaxBox = (message, color) =>{	
	ajaxMessages.style.backgroundColor = color
	ajaxMessages.innerHTML = message
	setTimeout(()=>{ ajaxMessages.className = 'hide' }, 1000)
}

const viewPayment = pId => { paymentDetails(pId) }
const deletePayment = pId => {
	const confirmed = confirm('Are you sure you want to delete ?')

	if (confirmed) {
		showAjaxBox('Deleting...')

		fetch(`deletePayment/${pId}`)
		.then(res => res.text())
		.then(text => {
			if (text != 'Deleted') {
				hideAjaxBox(text, 'red')
			}
			else{
				hideAjaxBox(text, 'green')
				qs(`#row_${pId}`).style.display = 'none'
			}
		})
	}
}
searchBox.addEventListener('input', function () {
	let query = searchBox.value.toLowerCase().trim()
	for (var i = 0; i < companyName.length; i++) {
		if (companyName[i].innerText.toLowerCase().indexOf(query) == -1) {
				companyName[i].parentElement.style.display = 'none'
				if (paymentDate[i].innerText.toLowerCase().indexOf(query) == -1) {
					paymentDate[i].parentElement.style.display = 'none'
					if (mode[i].innerText.toLowerCase().indexOf(query) == -1) {
						mode[i].parentElement.style.display = 'none'
					}
					else{
						mode[i].parentElement.style.display = 'table-row'
					}
				}
				else{
					paymentDate[i].parentElement.style.display = 'table-row'
				}
		}
		else{
			companyName[i].parentElement.style.display = 'table-row'
		}
	} // for Loop
})

const paymentDetails = pId => {
	viewPopup.click()
	qs('#paymentDetails').innerHTML = '<section id="logoSection"><img src="logo" id="logoImg" /><img src="gear" id="gearImg" /></section>'

	fetch(`fetchPayment/${pId}`).then(r => r.text()).then(txt =>{ qs('#paymentDetails').innerHTML = txt })

	// let xmlhttp = new XMLHttpRequest()
	// xmlhttp.onreadystatechange = function () {
	// 	if (this.readyState == 4 && this.status == 200) {
	// 		qs('#paymentDetails').innerHTML = this.responseText
	// 	}
	// }
	// xmlhttp.open("GET", `fetchPayment/${pId}`, true)
	// xmlhttp.send()
}

let dismissBtn = qs('#dismiss')
let viewPopup = qs('#view')
let popupBox = qs('#popupBox')
let content = qs('#content')
viewPopup.addEventListener('click', () => {
	popupBox.style.display = 'inline-block'
	setTimeout(() => {
		popupBox.style.opacity = 1;
	}, 200)
	setTimeout(() => {
		content.style.transform = 'translate(-50%,-50%) scale(1)'
	}, 300)
})
dismissBtn.addEventListener('click', () => {
	content.style.transform = 'translate(-50%,-50%) scale(0)'
	setTimeout(() => {
		popupBox.style.opacity = 0;
		popupBox.style.display = 'none'
	}, 200)
})
window.addEventListener('click', event => {
	if (event.target == popupBox) { dismissBtn.click() }
})
window.addEventListener('keydown', event =>	 {
	if (event.key == 'Escape') { dismissBtn.click() }
})