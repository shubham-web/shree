const data = [
	// month, sales, expenses
	{ month: 'Sep',	sales: 225000 , expenses: 410000 },
	{ month: 'Oct', sales: 253000, expenses: 325000 },
	{ month: 'Nov', sales: 310000, expenses: 159000 },
	{ month: 'Dec', sales: 256000, expenses: 214000 },
	{ month: 'Jan', sales: 58200, expenses: 100000 }
]

const monthDivs = document.querySelectorAll('section#graph main > div')
const monthName = document.querySelectorAll('section#graph footer > span')
for (let i = 0; i < monthDivs.length; i++) {
	const salesBar = monthDivs[i].firstElementChild
	const expensesBar = monthDivs[i].lastElementChild
	const salesPercentage = ((data[i].sales) / 500000) * 100
	const expensesPercent = ((data[i].expenses) / 500000) * 100
	monthName[i].innerHTML = data[i].month
	setTimeout(() => {
		salesBar.style.height = `${salesPercentage}%`
		expensesBar.style.height = `${expensesPercent}%`
	}, 100)

}
const pillers = document.querySelectorAll('section#graph main > div .bar')
window.addEventListener('load', () =>{
	pillerInfo.style.top = '0'
	pillerInfo.style.left = '0'
})
for (let piller of pillers) {
	piller.addEventListener('mouseenter', e => {
		pillerInfo.style.opacity = 1
		console.log(e)
		scrollTo(500,500)
	})
	piller.addEventListener('mouseleave', e => {
		pillerInfo.style.opacity = 0
	})
	piller.addEventListener('mousemove', e => {
		pillerInfo.style.left = `${e.screenX - window.parent.header.width}px`
		pillerInfo.style.top = `${e.screenY}px`
	})
}