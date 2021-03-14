// DOM
const qs = selector => document.querySelector(selector)
const reportSection = qs('#reports')
const reportBoxes = document.querySelectorAll('.reportBox')
// EventListeners
for (let div of reportBoxes) {
	div.addEventListener('click', ()=>{
		window.location.href = div.id
	})
}
window.addEventListener('load', () => {
	const dateObject = new Date()
	const month = dateObject.getMonth() + 1
	const year = dateObject.getFullYear()
	fetch(`reportStatistics/${month}/${year}`)
	.then(r => r.json())
	.then(data => {
		qs('#totalBills').innerHTML = `${data['totalBills']} Bills This Month`
		qs('#billAmt').innerHTML = `Worth Rs. ${data['billAmount']}`
		qs('#spentAmt').innerHTML = `Spent Rs. ${data['spentAmount']} This Month`
		qs('#totalGatepasses').innerHTML = `${data['gatepasses']} Gatepasses Received`
		qs('#chalans').innerHTML = `${data['chalans']} Chalans Generated`
		qs('#pendingGp').innerHTML = `${data['pendingGatepasses']} Gatepasses are pending`
	})
	pillerInfo.style.top = '0'
	pillerInfo.style.left = '0'
})

if(localStorage.recentReports == undefined){
	const recentReports = {
		companyWise: [],
		sales: [],
		purchase: [],
		delivered: [],
		received: []
	}
	localStorage.recentReports = JSON.stringify(recentReports)
}

// Graph
fetch(`getGraphData`)
.then(t => t.text())
.then(txt => {
	if (txt.startsWith('[') || txt.startsWith('{')) {
		const data = JSON.parse(txt).reverse()
		renderGraph(data)
	}
	else{
		alert('Error While Rendering The Graph!')
	}
})

const renderGraph = data => {
	const monthDivs = document.querySelectorAll('section#graph main > div')
	const monthName = document.querySelectorAll('section#graph footer > span')
	for (let i = 0; i < monthDivs.length; i++) {
		const salesBar = monthDivs[i].firstElementChild
		const expensesBar = monthDivs[i].lastElementChild
		const salesPercentage = ((data[i].sales) / 500000) * 100
		const expensesPercent = ((data[i].expenses) / 500000) * 100
		salesBar.setAttribute('data-amount', data[i].sales)
		expensesBar.setAttribute('data-amount', data[i].expenses)
		salesBar.setAttribute('data-type', 'Income')
		expensesBar.setAttribute('data-type', 'Expenses')
		monthName[i].innerHTML = data[i].month
		setTimeout(() => {
			salesBar.style.height = `${salesPercentage}%`
			expensesBar.style.height = `${expensesPercent}%`
		}, 100)
	}
	const pillers = document.querySelectorAll('section#graph main > div .bar')
	for (let piller of pillers) {
		piller.addEventListener('mouseenter', e => {
			pillerType.innerHTML = `${piller.dataset.type}`
			pillerAmt.innerHTML = `Rs. ${piller.dataset.amount}`
			pillerInfo.style.opacity = 1
			scrollTo(0,300)
		})
		piller.addEventListener('mouseleave', e => {
			pillerInfo.style.opacity = 0
		})
		piller.addEventListener('mousemove', e => {
			pillerInfo.style.left = `${e.screenX - window.parent.sidebarMenu.clientWidth - 5}px`
			pillerInfo.style.top = `${e.screenY - pillerInfo.clientHeight + 20 - window.parent.header.clientHeight}px`
		})
	}
}