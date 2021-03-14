// DOM 
const $ = selector => document.querySelector(selector)
const createSalaryBtn = $('#addNewBtn')
const searchBox = $('#searchInput')
const backIcon = $('#backIcon')
const ajaxMessages = $('#ajaxMessages')
const view = date => { window.open(`salary/${date}`) }

// Table Data NodeLists For Searching
const date = document.querySelectorAll('.date')
const avgDays = document.querySelectorAll('.avgDays')
const avgSalary = document.querySelectorAll('.avgSalary')
const paid = document.querySelectorAll('.paid')

// Event Listeners
$('#searchIcon').addEventListener('click', () => searchInput.focus())
createSalaryBtn.addEventListener('click', () =>{
	window.location.href = 'createSalary'
})
backIcon.addEventListener('click', () => {
	window.history.back()
})
$('html').addEventListener('keydown', event => {
	if (event.key == 's' && event.altKey) searchBox.focus()
	if (event.key == 'n' && event.altKey) createSalaryBtn.click()
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

const deleteSalary = date => {
	const confirmed = confirm('Are you sure you want to Permanently delete?')
	if (confirmed) {
		showAjaxBox('Deleting...')
		fetch(`deleteSalary/${date}`)
		.then(res => res.text())
		.then(text => {
			if (text != 'Deleted') {
				hideAjaxBox(text, 'red')
			}
			else{
				hideAjaxBox(text, 'green')
				$(`#row_${date}`).style.display = 'none'
			}
		})
	}
}


searchBox.addEventListener('input', () => {
	let query = searchBox.value.toLowerCase().trim()
	for (var i = 0; i < date.length; i++) {
		if ((date[i].innerText.toLowerCase().indexOf(query) == -1)) {
				date[i].parentElement.style.display = 'none'
				if (avgDays[i].innerText.toLowerCase().indexOf(query) == -1) {
					avgDays[i].parentElement.style.display = 'none'
					if (avgSalary[i].innerText.toLowerCase().indexOf(query) == -1) {
						avgSalary[i].parentElement.style.display = 'none'
						if (paid[i].innerText.toLowerCase().indexOf(query) == -1) {
							paid[i].parentElement.style.display = 'none'
						}
						else{
							paid[i].parentElement.style.display = 'table-row'
						}
					}
					else{
						avgSalary[i].parentElement.style.display = 'table-row'
					}
				}
				else{
					avgDays[i].parentElement.style.display = 'table-row'
				}
		}
		else{
			date[i].parentElement.style.display = 'table-row'
		}
	}
})