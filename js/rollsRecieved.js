const $ = selector => document.querySelector(selector)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
    message.className = "show";
    setTimeout(() => { message.className = message.className.replace("show", ""); }, 3000);
}

// DOM
const yearDropdown = $('#year')
const monthDropdown = $('#month')
const generateBtn = $('#generate')
const message = $('#message')
window.addEventListener('load', () => {
	fetch(`fetchYears/gatepasses/gatepassDate`)
	.then(r => r.text())
	.then(text => {
		yearDropdown.innerHTML = '<option value="">---Year---</option>'
		yearDropdown.innerHTML += text
	})
	loadRecentReports()
})
yearDropdown.addEventListener('change', () => {
	year = yearDropdown.value
	if (year == '') {
		monthDropdown.disabled = true
		monthDropdown.innerHTML = '<option value="">Select Year First</option>'
	}
	else{
		let forMonth = new XMLHttpRequest()
		forMonth.onreadystatechange = function() {
			if (this.readyState == 1) {
				monthDropdown.disabled = true
				monthDropdown.innerHTML = '<option value="">Loading...</option>'
			}
			if (this.readyState == 4 && this.status == 200) {
				monthDropdown.disabled = false
				monthDropdown.innerHTML = '<option value="">---Month---</option>'
				monthDropdown.innerHTML += this.responseText
			}
		}
		forMonth.open("GET",`fetchMonths/${year}/gatepasses/gatepassDate`, true)
		forMonth.send()
	}
})


const logAsRecent = (month, year, link) => {
	let recentReports =  JSON.parse(localStorage.recentReports)
	let received = recentReports.received
	const monthArray = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
	let title = `${monthArray[month - 1]} - ${year}`

	received.unshift({title: `${title}`, link: `${link}`})
	if (received.length > 3) received.pop()
	recentReports.received = received
	recentReports = JSON.stringify(recentReports)
	localStorage.recentReports = recentReports

	loadRecentReports()
}

generateBtn.addEventListener('click', () => {
	year = yearDropdown.value
	month = monthDropdown.value
	monthArr = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	if (year == '') {
		yearDropdown.focus()
		showMessage('black', 'Select Year')
	}
	else if (month == ''){
		monthDropdown.focus()
		showMessage('black', 'Select month')
	}
	else{
		const link = `rollsRecieved/${year}/${month}` 
		window.open(link)
		logAsRecent(month, year, link)
	}
})

$('#backIcon').addEventListener('click', () => {
	if (window.parent.document.title.indexOf('Dashboard') == 0) {
		window.parent.location.reload()
	}
	else{
		window.history.back()
	}
})

const loadRecentReports = () => {
	const recentSection = $('.recentReports')
	if (localStorage.recentReports == undefined || JSON.parse(localStorage.recentReports).received.length == 0) {
		recentSection.style.display = 'none'
	}
	else{
		recentSection.style.display = 'inline-block'
		let recentReports =  JSON.parse(localStorage.recentReports)
		let received = recentReports.received
		const list = ($('.recentReports ul'))
		list.innerHTML = ''
		for (let report of received) {
			let item = document.createElement('LI')
			item.innerHTML = report.title
			item.addEventListener('click', () => { window.open(`${report.link}`) })
			list.appendChild(item)
		}
	}
}