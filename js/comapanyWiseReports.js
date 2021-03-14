const $ =  selector => document.querySelector(selector)
const showMessage = (color, whatToShow) => {
	message.style.backgroundColor = color
	message.style.color = 'white'
	message.innerHTML = whatToShow
    message.className = "show"
    setTimeout(() => { message.className = message.className.replace("show", "") }, 3000)
}
const dateObject = new Date()
let dd = dateObject.getDate()
let mm = dateObject.getMonth()+1
if (dd < 10) { dd = `0${dd}` }
if (mm < 10) { mm = `0${mm}` }
const yyyy = dateObject.getFullYear()
const today = `${yyyy}-${mm}-${dd}`
// DOM
const selectCompany = $('#company')
const selectReportOf = $('#reportOf')
const radioYear = $('#yearWise')
const radioMonth = $('#monthWise')
const radioDate = $('#dateWise')

const criteriaBlock = $('#criteria')
const sectionYearWise = $('#yearWiseInput')
const sectionMonthWise = $('#monthWiseInput')
const sectionDateWise = $('#dateWiseInput')

// Duration Inputs
const yearOnly = $('#yearOnly')
const monthWiseYear = $('#monthWiseYear')
const monthWiseMonth = $('#monthWiseMonth')
const toDate = $('#dateWiseTo')
const fromDate = $('#dateWiseFrom')

submitBtn = $('#submitBtn')


window.onload = () => {
	fetchCompany = new XMLHttpRequest()
	fetchCompany.onreadystatechange = function () {
		if (fetchCompany.readyState == 1) {
			selectCompany.innerHTML = '<option value="">Loading...</option>'
		}
		if (fetchCompany.readyState == 4 && fetchCompany.status == 200) {
			selectCompany.innerHTML = '<option value="">---Select Company---</option>'
			companiesArray = JSON.parse(fetchCompany.responseText)
			for (company of companiesArray) {
				selectCompany.innerHTML += `<option value="${company[0]}">${company[1]}</option>`
			}
		}
	}
	fetchCompany.open("GET", "fetchCompanies", true)
	fetchCompany.send()
	// -----------------------------------------------------------
	/*-------------To set the max value of date -----------------*/
	toDate.value = today
	toDate.max = today
	fromDate.max = today

	loadRecentReports()
}

const hideAll = () => {
	sectionYearWise.style.display = 'none'
	sectionMonthWise.style.display = 'none'
	sectionDateWise.style.display = 'none'
	setTimeout(() => {
		sectionYearWise.style.transform = 'scale(0)'
		sectionMonthWise.style.transform = 'scale(0)'
		sectionDateWise.style.transform = 'scale(0)'
	}, 100)
}
radioYear.onclick = () => {
	hideAll()
	sectionYearWise.style.display = 'block'
	setTimeout(() => { sectionYearWise.style.transform = 'none' }, 100)	
}
radioMonth.onclick = () => {
	hideAll()
	sectionMonthWise.style.display = 'block'
	setTimeout(() => { sectionMonthWise.style.transform = 'none' }, 100)
}
radioDate.onclick = () => {
	hideAll()
	sectionDateWise.style.display = 'block'
	setTimeout(() => { sectionDateWise.style.transform = 'none' }, 100)
}
monthWiseYear.addEventListener('change', () => {
	if(monthWiseYear.value == ''){
		monthWiseMonth.disabled = true
		monthWiseMonth.innerHTML = `<option value="">---Select Year First---</option>`
	}
	else{
		monthWiseMonth.innerHTML = `<option value="">Loading...</option>`
		const year = monthWiseYear.value
		fetch(`fetchMonthsByCompanyId/${selectCompany.value}/${selectReportOf.value}/${year}`)
		.then(response => response.json())
		.then(jsonData => {
			const monthArr = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
			jsonData.sort()	
			monthWiseMonth.disabled = false
			monthWiseMonth.innerHTML = `<option value="">---Select Month---</option>`
			for (const m of jsonData) {
				monthWiseMonth.innerHTML += `<option value="${m}">${monthArr[m-1]}</option>`
			}
		})
	}
})
const getYearList = () => {
		if (selectCompany.value != '') {
		let companyId = selectCompany.value
		let reportof = selectReportOf.value /* Table Name */
		let fetchYears = new XMLHttpRequest()
		fetchYears.onreadystatechange = function () {
			if (this.readyState == 1) {
				yearOnly.disabled = true
				yearOnly.innerHTML = `<option value=''>Loading...</option>`

				monthWiseYear.disabled = true
				monthWiseYear.innerHTML = `<option value=''>Loading...</option>`
			}
			if (this.readyState == 4 && this.status == 200) {
				let yearArray = JSON.parse(this.responseText)
				yearArray.sort()
				if (yearArray.length == 0) {
					monthWiseYear.innerHTML = yearOnly.innerHTML = `<option value="false">---Data Unavailable---</option>`
				}
				else{
					yearOnly.disabled = false
					yearOnly.innerHTML = `<option value="">---Select Year---</option>`
					for (let i = 0; i < yearArray.length; i++) {
						yearOnly.innerHTML += `<option value="${yearArray[i]}">${yearArray[i]-1} - ${yearArray[i].slice(2)}</option>`
					}

					monthWiseYear.disabled = false
					monthWiseYear.innerHTML = `<option value="">---Select Year---</option>`
					for (let i = 0; i < yearArray.length; i++) {
						monthWiseYear.innerHTML += `<option value="${yearArray[i]}">${yearArray[i]}</option>`
					}
				} // Else
			}
		}
		fetchYears.open(`GET`, `fetchYearsByCompanyId/${companyId}/${reportof}`, true)
		fetchYears.send()
	}
	else{
		yearOnly.disabled = false
		yearOnly.innerHTML = `<option value="">---Select Year---</option>`

		monthWiseYear.disabled = false
		monthWiseYear.innerHTML = `<option value="">---Select Year---</option>`
	}
}
selectCompany.onchange = () => { getYearList() }
selectReportOf.onchange = () => { getYearList() }

const logAsRecent = (reportof, companyId, link) => {
	let title = ''
	let companyName = $(`#company [value="${companyId}"]`).innerText

	if (reportof == 'gatepasses') {
		title = 'All Gatepasses'
	}
	else if (reportof == 'chalans') {
		title = 'All Chalans'
	}
	else if (reportof == 'bills') {
		title = 'All Bills'
	}
	else if (reportof == 'payments') {
		title = 'All Payments'
	}


	let recentReports =  JSON.parse(localStorage.recentReports)
	let companyWise = recentReports.companyWise

	companyWise.unshift({title: `${title} of ${companyName}`, link: `${link}`})
	if (companyWise.length > 3) {
		companyWise.pop()
	}

	recentReports.companyWise = companyWise
	recentReports = JSON.stringify(recentReports)
	localStorage.recentReports = recentReports
	loadRecentReports()
}

submitBtn.addEventListener('click',() => {
	let companyId = selectCompany.value
	let reportof = selectReportOf.value
	let reportCriteria = ''
	if (radioYear.checked) reportCriteria = 'yearWise'
	if (radioMonth.checked) reportCriteria = 'monthWise'
	if (radioDate.checked) reportCriteria = 'dateWise'
	if (companyId == '') {
		showMessage('dodgerblue', 'Select Company')
		selectCompany.focus()
	}
	else if(reportCriteria == ''){
		showMessage('red', 'Choose Criteria')
	}
	else{
		if (reportCriteria == 'yearWise') {
			if (yearOnly.value == '') {
				showMessage('red', 'Select Year')
				yearOnly.focus()
			}
			else if (yearOnly.value == 'false') {
				showMessage('orangered', 'Data Unavailable of this Company')
				selectCompany.focus()
			}
			else{
				const link = `reports/${reportof}/year/${companyId}/${yearOnly.value}`
				window.open(link)
				logAsRecent(reportof, companyId, link)
			}
		}
		else if (reportCriteria == 'monthWise') {
			if (monthWiseYear.value == '') {
				showMessage('dodgerblue', 'Select Year')
				yearOnly.focus()
			}
			else if (monthWiseYear.value == 'false') {
				showMessage('orangered', 'Data Unavailable of this Company')
				selectCompany.focus()
			}
			else if (monthWiseMonth.value == '') {
				showMessage('dodgerblue', 'Select Month')
				monthWiseMonth.focus()
			}
			else{
				const link = `reports/${reportof}/month/${companyId}/${monthWiseYear.value}/${monthWiseMonth.value}`
				window.open(link)
				logAsRecent(reportof, companyId, link)
			}
		}
		else if (reportCriteria == 'dateWise') {
			if (dateWiseFrom.value == '') {
				showMessage('dodgerblue', 'Select Starting Date')
				dateWiseFrom.focus()
			}
			else if (dateWiseTo.value == '') {
				showMessage('dodgerblue', 'Select End Date')
				dateWiseTo.focus()
			}
			else if (dateWiseFrom.value > dateWiseTo.value) {
				showMessage('dodgerblue', 'Start Date Should Be less than End Date')
				dateWiseFrom.focus()
			}
			else{
				const link = `reports/${reportof}/date/${companyId}/${dateWiseFrom.value}/${dateWiseTo.value}`
				window.open(link)
				logAsRecent(reportof, companyId, link)
			}
		}
	}
})
$('#backIcon').onclick = () => {
	if (window.parent.document.title.indexOf('Dashboard') == 0)	window.parent.location.reload()
	else window.history.back()
}

const loadRecentReports = () => {
	const recentSection = $('.recentReports')
	if (localStorage.recentReports == undefined || JSON.parse(localStorage.recentReports).companyWise.length == 0) {
		recentSection.style.display = 'none'
	}
	else{
		recentSection.style.display = 'inline-block'
		let recentReports =  JSON.parse(localStorage.recentReports)
		let companyWise = recentReports.companyWise
		const list = ($('.recentReports ul'))
		list.innerHTML = ''
		for (let report of companyWise) {
			let item = document.createElement('LI')
			item.innerHTML = report.title
			item.addEventListener('click', () => { window.open(`${report.link}`) })
			list.appendChild(item)
		}
	}
}
