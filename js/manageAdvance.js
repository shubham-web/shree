// DOM
const $ = selector => document.querySelector(selector)
const newEntryBtn = $('#addNewBtn')
const backIcon = $('#backIcon')
const searchInput = $('#searchInput')

// Table Data Node List For Searching
const date = document.querySelectorAll('.date')
const employeeNames = document.querySelectorAll('.employeeNames')
const takenAmt = document.querySelectorAll('.takenAmt')
const returnedAmt = document.querySelectorAll('.returnedAmt')
const totalDue = document.querySelectorAll('.totalDue')

// EventListeners 
newEntryBtn.addEventListener('click', () => {
	window.location.href = 'newLoan'
})
backIcon.addEventListener('click', () => {
	window.history.back()
})

searchInput.addEventListener('input', () => {
	let query = searchInput.value.toLowerCase().trim()
	for (var i = 0; i < date.length; i++) {
		if ((date[i].innerText.toLowerCase().indexOf(query) == -1)) {
			date[i].parentElement.style.display = 'none'
			if (employeeNames[i].innerText.toLowerCase().indexOf(query) == -1) {
				employeeNames[i].parentElement.style.display = 'none'
				if (takenAmt[i].innerText.toLowerCase().indexOf(query) == -1) {
					takenAmt[i].parentElement.style.display = 'none'
					if (returnedAmt[i].innerText.toLowerCase().indexOf(query) == -1) {
						returnedAmt[i].parentElement.style.display = 'none'
						if (totalDue[i].innerText.toLowerCase().indexOf(query) == -1) {
							totalDue[i].parentElement.style.display = 'none'
							
						}
						else{
							totalDue[i].parentElement.style.display = 'table-row'
						}
					}
					else{
						returnedAmt[i].parentElement.style.display = 'table-row'
					}
				}
				else{
					takenAmt[i].parentElement.style.display = 'table-row'
				}
			}
			else{
				employeeNames[i].parentElement.style.display = 'table-row'
			}
		}
		else{
			date[i].parentElement.style.display = 'table-row'
		}
	}
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

const deleteEntry = id => {	
	const confirmed = confirm('Are you sure you want to delete ?')
	if (confirmed) {
		showAjaxBox('Deleting...')
		fetch(`deleteLoan/${id}`)
		.then(res => res.text())
		.then(text => {
			if (text != 'Deleted') {
				hideAjaxBox(text, 'red')
			}
			else{
				hideAjaxBox(text, 'green')
				$(`#row_${id}`).style.display = 'none'
			}
		})
	}
}