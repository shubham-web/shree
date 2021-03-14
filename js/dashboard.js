// DOM Elements
const $ = selector => document.querySelector(selector)
const logoutBtn = $('#logout')
const emailbutton = $('#email')
const logoutText = $('#logoutText')
const images = document.querySelectorAll('img')
const infoBoxes = document.querySelectorAll('.infoBox')
const notifySound = $('#notifySound')
let soundLoaded = false
notifySound.oncanplay = () => soundLoaded = true
notifySound.onerror = () => soundLoaded = false

// Menu
const addBills = $('#addBills')
const b2bReport = $('#b2bReport')
const gstr2Report = $('#gstr2Report')
const salesReport = $('#salesReport')
const purchaseReport = $('#purchaseReport')

const homeMenu = $('#home')
const companyMenu = $('#company')
const vendorsMenu = $('#vendors')
const reportsMenu = $('#reports')
const trashMenu = $('#trash')
const employeeMenu = $('#employee')
const vouchersMenu = $('#vouchers')
const expensesMenu = $('#expenses')
const manageChalansMenu = $('#manageChalans')
const manageBillsMenu = $('#manageBills')
const manageGatepassMenu = $('#manageGatepass')
const managePaymentMenu = $('#managePayment')
const headerHeading = $('#headerHeading')
const sidebarMenu = $('#sidebarMenu')
const contextmenu = $('#contextMenu')
const header = $('#dashboard header')
const contextMenuItem = document.querySelectorAll('.contextMenuItem')
window.__proto__.contextMenu = contextMenu
window.__proto__.sidebarMenu = sidebarMenu
window.__proto__.header = header

let buttonArr = [
	homeMenu,
	companyMenu,
	vendorsMenu,
	reportsMenu,
	manageChalansMenu,
	manageBillsMenu,
	manageGatepassMenu,
	managePaymentMenu,
	expensesMenu,
	employeeMenu,
	vouchersMenu,
	trashMenu
]

const removeActive = () => {
	for (var i = 0; i < buttonArr.length; i++) {
		if(buttonArr[i].classList.contains('active')){
			buttonArr[i].classList.remove('active')
			buttonArr[i].disabled = false
		}
	}
}
const loader = $('#loader')
const mainContainer = $('#container')
const mainWrapper = $('#mainWrapper')
const showLoader = () => {
	loader.style.zIndex = '1000'
	loader.style.opacity = '1'
}
const hideLoader = () => {
	loader.style.zIndex = '-1'
	loader.style.opacity = '0'
}
let loadPage = (fileName, linkObject = '', hash = '') => {
	   	removeActive()
		showLoader()
	 	mainWrapper.innerHTML = "<iframe src="+fileName+" frameborder='0' id='iframe'></iframe>"
	 	if (linkObject != '') {
		   	linkObject.classList.add('active')
		   	linkObject.disabled = true
	 	}
	   	if ($('#iframe').onload === null) $('#iframe').onload = hideLoader 
	   	window.location.hash = hash
}
const printTasks = list => {
	let todoList = new Set()
	$(`#todos`).innerHTML = ''
	if (list.length == 0) {
		$(`#todos`).innerHTML = '<h1 id="emptyToDo">No Tasks  🎉</h1><small class="infoText">Click on Add (+) Button to add new Tasks</small>'
		$(`#undoneTasks`).innerHTML = `${list.length} Tasks`
	}
	else{
		const undoneTasks = list.filter(item => !item.isDone)
		$(`#undoneTasks`).innerHTML = `${undoneTasks.length} Tasks`
		let distinctDates = new Set()
		const todaysDate = new Date().toLocaleDateString()
		for (let item of list) { distinctDates.add(item.date) }
		for (let date of distinctDates) { todoList[date] = list.filter(task => task.date === date) }
		distinctDates = Array.from(distinctDates) // Convert Set Instance into an array
		distinctDates.reverse() // To Sort the dates in Descending order
		for (let date of distinctDates) {
			let timeStamp
			if (date == todaysDate) {
				timeStamp = 'Today'
			}
			else if (date == new Date(new Date(todaysDate) - 1).toLocaleDateString()) {
				timeStamp = 'Yesterday'
			}
			else{
				timeStamp = new Date(date).toDateString()
			}
			todoList[date].reverse()
			let taskArray = todoList[date]
			let todoComponent = ''
			todoComponent += `<span class="timeStamp">  ${timeStamp}</span>`
			todoComponent += `<table>`
			for (let task of taskArray) {
				let taskDone = (task.isDone) ? "checked":""
				todoComponent += 
				`<tr id="__${task.id}">
					<td><span class="checkbox"><input type="checkbox" ${taskDone}  id="todo${task.id}"></span></td>
					<td class="todoTitleData"><label class="todoTitle ${taskDone}" for="todo${task.id}">${sbSystem(task.title)}</label></td>
					<td><button class="deleteTodo">&times;</button></td>
				</tr>`
			}
			todoComponent += `</table>`
			$(`#todos`).innerHTML += todoComponent

			const deleteTodos = document.querySelectorAll('.deleteTodo')
			const checkMarks = document.querySelectorAll('.checkbox')
			const todoTitleData = document.querySelectorAll('.todoTitleData')
			for (let delBtn of deleteTodos) {
				delBtn.addEventListener('click', () => {
					let todoId = delBtn.parentElement.parentElement.id.slice(2)
					deleteTodo(todoId)
				})
			}
			for (let checkMark of checkMarks){
				let todoId = checkMark.children[0].id.slice(4)
				checkMark.children[0].addEventListener('click', () => {
					taskDone(todoId, checkMark.children[0].checked)
				})
			}
		}
	} // Else
}

const getLocationHash = () => {
	const menuHashes = [
		{'hash': '', 'menuBtn': homeMenu},
		{'hash': '#gatepasses', 'menuBtn': manageGatepassMenu},
		{'hash': '#chalans', 'menuBtn': manageChalansMenu},
		{'hash': '#bills', 'menuBtn': manageBillsMenu},
		{'hash': '#payments', 'menuBtn': managePaymentMenu},
		{'hash': '#expenses', 'menuBtn': expensesMenu},
		{'hash': '#reports', 'menuBtn': reportsMenu},
		{'hash': '#employees', 'menuBtn': employeeMenu},
		{'hash': '#vouchers', 'menuBtn': vouchersMenu},
		{'hash': '#companies', 'menuBtn': companyMenu},
		{'hash': '#vendors', 'menuBtn': vendorsMenu},
		{'hash': '#trashItems', 'menuBtn': trashMenu}
	]
	const internalPageHashes = [
		{'hashURL': 'newGatepass', 'parentMenu':manageGatepassMenu},
		{'hashURL': 'pendingGatepasses', 'parentMenu':manageGatepassMenu},
		{'hashURL': 'newChalan', 'parentMenu':manageChalansMenu},
		{'hashURL': 'newBill', 'parentMenu':manageBillsMenu},
		{'hashURL': 'newManualBill', 'parentMenu':manageBillsMenu},
		{'hashURL': 'addPayment', 'parentMenu':managePaymentMenu},
		{'hashURL': 'addExpenses', 'parentMenu':expensesMenu},

		{'hashURL': 'gstr1', 'parentMenu':reportsMenu},
		{'hashURL': 'gstr2', 'parentMenu':reportsMenu},
		{'hashURL': 'salesReport', 'parentMenu':reportsMenu},
		{'hashURL': 'purchaseReport', 'parentMenu':reportsMenu},
		{'hashURL': 'rollsDelivered', 'parentMenu':reportsMenu},
		{'hashURL': 'rollsRecieved', 'parentMenu':reportsMenu},
		{'hashURL': 'companyWiseReports', 'parentMenu':reportsMenu},
		{'hashURL': 'newEmployee', 'parentMenu':employeeMenu},
		{'hashURL': 'manageSalary', 'parentMenu':employeeMenu},
		{'hashURL': 'manageSalary', 'parentMenu':employeeMenu},
		{'hashURL': 'createSalary', 'parentMenu':employeeMenu},
		{'hashURL': 'newVoucher', 'parentMenu':vouchersMenu},
		{'hashURL': 'newCompany', 'parentMenu':companyMenu},
		{'hashURL': 'newVendor', 'parentMenu':vendorsMenu},
	]
	let notMenu = false
	for (let data of menuHashes) {
		if (window.location.hash == data['hash']) {
			data['menuBtn'].click()
			break
		}
		notMenu = data == menuHashes[menuHashes.length - 1] && data['hash'] != window.location.hash
	}
	let notInternalHash = false
	if (notMenu) {
		for (let page of internalPageHashes) {
			if (window.location.hash == `#${page['hashURL']}`) {
				loadPage(page['hashURL'], page['parentMenu'], page['hashURL'])
				break
			}
			else{
				notInternalHash = page == internalPageHashes[internalPageHashes.length - 1] && `#${page['hashURL']}` != window.location.hash
			}
		}
	}
	if (notInternalHash) window.location.hash = ''
 }

// Event Listeners
window.addEventListener('load', () => {
	hideLoader()
	for (let box of infoBoxes) {
		box.className = 'infoBox launch'
	}
	$('#fullScreenLi').innerHTML = (document.webkitIsFullScreen) ? `Exit Full Screen`:`Enter Full Screen`
	if (Notification.permission === 'default')
		Notification.requestPermission()
	if (window.location.hash == '') {
		fetch(`tasksToDo.json`, {
			cache: "no-cache"
		})
		.then(response => response.json())
		.then(jsonTodos => { printTasks(jsonTodos) })
		.catch(error => console.error('Error:', error))
		if (localStorage.activeAccordion != undefined) {
			if ($(`#${localStorage.activeAccordion}`) != null) {
				$(`#${localStorage.activeAccordion}`).click()
			}
		}
	}
	else{
		getLocationHash()
	}
})
year.innerHTML = new Date().getFullYear()
window.addEventListener('hashchange', event => {
	getLocationHash()
})
const extraNavigation = () =>{
	if (eval(window.innerHeight) > 700) {
		$(`#more`).style.display = 'none'
		$(`.extraNavigation`).id = ''
	}
	else{
		$(`#more`).style.display = 'inline-flex'
		$(`.extraNavigation`).id = 'moreItems'
	}
}
window.addEventListener('load', extraNavigation)
window.addEventListener('resize', extraNavigation)
document.onwebkitfullscreenchange = () => {
	$('#fullScreenLi').innerHTML = (document.webkitIsFullScreen) ? `Exit Full Screen`:`Enter Full Screen`
}

for (let img of images) {
	img.addEventListener('error', () => { img.style.display = 'none' } )
	img.draggable = false
}
$('#logo').addEventListener('error', () => {
	siteTitle.innerHTML = 'Shree\
	Engineering\
	Works'
})

$('#siteTitle').onclick = () => {
	if (window.location.hash == '') {
		window.location.reload()
	}
	else{
		window.location.hash = ''
	}
}

homeMenu.onclick = () => {
	removeActive()
   	homeMenu.classList.add('active')
	window.location.hash = ''
	window.location.reload()
}

expensesMenu.onclick = () => {
	headerHeading.innerHTML = 'Expenses'
	loadPage('expenses', expensesMenu, 'expenses')
	document.title = 'Manage Expenses | Shree Engineering Works'
}
manageChalansMenu.onclick = () => {
	headerHeading.innerHTML = 'Chalans'
	loadPage('chalans', manageChalansMenu, 'chalans')
	document.title = 'Manage Chalans | Shree Engineering Works'
}
manageBillsMenu.onclick = () => {
	headerHeading.innerHTML = 'Bills'
	loadPage('bills', manageBillsMenu, 'bills')
	document.title = 'Manage Bills | Shree Engineering Works'
	window.location.hash = '#bills'
}
manageGatepassMenu.onclick = () => {
	headerHeading.innerHTML = 'Gatepasses'
	loadPage('gatepasses', manageGatepassMenu, 'gatepasses')
	document.title = 'Manage Gatepasses | Shree Engineering Works'
}
managePaymentMenu.onclick = () => {
	headerHeading.innerHTML = 'Payments'
	loadPage('payments', managePaymentMenu, 'payments')
	document.title = 'Manage Payments | Shree Engineering Works'
}

employeeMenu.onclick = () => {
	headerHeading.innerHTML = 'Employees'
	loadPage('employees', employeeMenu, 'employees')
	document.title = 'Manage Employees | Shree Engineering Works'
}
companyMenu.onclick = () => {
	headerHeading.innerHTML = 'Companies'
	loadPage('companies', companyMenu, 'companies')
	document.title = 'Manage Company Profiles | Shree Engineering Works'
}
vendorsMenu.onclick = () => {
	headerHeading.innerHTML = 'Vendors'
	loadPage('vendors', vendorsMenu, 'vendors')
	document.title = 'Manage Vendors | Shree Engineering Works'
}
reportsMenu.onclick = () => {
	headerHeading.innerHTML = 'Reports'
	loadPage('reports', reportsMenu, 'reports')
	document.title = 'Generate Reports | Shree Engineering Works'	
}
vouchersMenu.onclick = () => {
	headerHeading.innerHTML = 'Vouchers'
	loadPage('vouchers', vouchersMenu, 'vouchers')
	document.title = 'Manage Vouchers | Shree Engineering Works'
}
trashMenu.onclick = () => {
	headerHeading.innerHTML = 'Trash'
	loadPage('trash', trashMenu, 'trashItems')
	document.title = 'Manage Trash | Shree Engineering Works'
}
document.onkeydown = event => {
	if (event.key === 'Escape') {
		window.hideContext()
	}
	if (event.altKey) {
		event.preventDefault()
		switch (event.key){
			case 'g':
				manageGatepassMenu.click()
				break
			case 'c':
				manageChalansMenu.click()
				break
			case 'b':
				manageBillsMenu.click()
				break
			case 'p':
				managePaymentMenu.click()
				break
			case 'e':
				expensesMenu.click()
				break
			case 'r':
				reportsMenu.click()
				break
			case 'i':
				companyMenu.click()
				break
			case 'v':
				vendorsMenu.click()
				break
			case 't':
				trashMenu.click()
				break
			case 'l':
				if (confirm('Are you sure you want to Logout ?')) logoutBtn.click()
		}
	}
}

//  Code for Custom Context Menu------------------------
document.oncontextmenu = (event) => {
	event.preventDefault()
	contextmenu.style.top = `${event.pageY}px`
	contextmenu.style.left = `${event.pageX}px`
	window.showContext()
	frame = $('iframe')
	if (frame !== null && frame.contentWindow.hideContext !== undefined) frame.contentWindow.hideContext()
}
document.onclick = (event) => {
	if (contextmenu.style.transform == 'scale(1)'
		 && event.target != contextmenu
		 && event.target != contextMenuItem[0] // Reload
		 && event.target != contextMenuItem[1] // Gatepasses
		 && event.target != contextMenuItem[2] // Manage Bills
		 && event.target != contextMenuItem[3] // Enter / Exit Full Screen
		 && event.target != contextMenuItem[4] // Log out 
		 ) window.hideContext()
	frame = $('iframe')
	if (frame !== null && frame.contentWindow.hideContext !== undefined) frame.contentWindow.hideContext()
}
contextMenuItem[0].onclick  = () => {
	window.location.reload()
}
contextMenuItem[1].onclick = () => {
	hideContext()
	manageGatepassMenu.click()
}
contextMenuItem[2].onclick = () => {
	hideContext()
	manageBillsMenu.click()
}
contextMenuItem[3].onclick = () => {
	hideContext()
	if (document.webkitIsFullScreen) {
		document.webkitExitFullscreen()
	}
	else{
		document.documentElement.webkitRequestFullscreen()
	}
}
contextMenuItem[4].onclick = () => {
	hideContext()
	logoutBtn.click()
}


window.__proto__.hideContext = () => {
	setTimeout(() => {
		contextMenu.style.transform = 'scale(0)'
	}, 50)
}
window.__proto__.showContext = () => {
	contextMenu.style.transform = 'scale(1)'
}
//  Code for Custom Context Menu Ends here ----------------
// --------------------------------------------------------

emailbutton.onclick = () => {
	let arrow = $('#arrow')
	if (logoutText.style.display == 'none') {
		logoutText.style.display = 'inline'
		arrow.style.transform = "rotate(-90deg)"
	}
	else{
		logoutText.style.display = 'none'
		arrow.style.transform = "rotate(0deg)"
	}
}


let logout = () => {
	logoutBtn.innerHTML = 'Logging out...'
	logoutBtn.disabled = true
	let xhttp = new XMLHttpRequest()
	xhttp.onreadystatechange = function () {
	   if (this.readyState == 4 && this.status == 200){
	   		if (this.responseText == 'Success') {
	   			window.location.replace(`login`)
	   			localStorage.removeItem('DoxsG0tsqU')
	   			localStorage.removeItem('smtWZ86pA2')
	   		}
	   		if (this.responseText == 'Failure') {
	   			alert('Logout Error')
	   			localStorage.removeItem('DoxsG0tsqU')
	   			localStorage.removeItem('smtWZ86pA2')
	   		}
	   } // on response loaded

	} // onReadyState function
	xhttp.open("POST", "functions", true)
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	xhttp.send("action=logout")
}

$('#dashboard').style.borderColor = (navigator.onLine) ? '#58e870':'orangered'
navigator.connection.onchange = () => $('#dashboard').style.borderColor = (navigator.onLine) ? '#58e870':'orangered'

reverify = setInterval(() => {
	if (localStorage.DoxsG0tsqU === undefined && localStorage.smtWZ86pA2 === undefined) {
		let sessionExpired = new Notification('Shree Engineering Works', {
			body: 'Logged Out',
			icon: 'img/shree.png',
			silent: true
		})
		if (soundLoaded) notifySound.play()
		setTimeout(() => { logoutBtn.click() }, 1000)
	}
	else{
		if (document.hasFocus()) {
			fetch(`checkAuth/${localStorage.DoxsG0tsqU}/${localStorage.smtWZ86pA2}`)
			.then(r => r.text())
			.then(txt => {
		   		if (txt === 'Session Expired') {
		   			clearInterval(reverify)
		   			if (soundLoaded) notifySound.play()
					let loggedOut = new Notification('Shree Engineering Works', {
						body: 'Session Expired',
						icon: 'img/shree.png',
						silent: true
					})
					setTimeout(() => {logoutBtn.click()}, 1000)
				}
			})
			.catch(err => {
				clearInterval(reverify)
	   			if (soundLoaded) notifySound.play()
				let loggedOut = new Notification('Shree Engineering Works', {
					body: 'Session Expired',
					icon: 'img/shree.png',
					silent: true
				})
				setTimeout(() => {logoutBtn.click()}, 1000)
			})
		} //  If Document Has Focus
	}
}, 5000)

logoutBtn.onclick = logout
logoutText.onclick =  logout

//  For accordion
const accordionHeadings = document.querySelectorAll('.accordionHead')
const expandArrows = document.querySelectorAll('.expandArrow')
const accordionDataULs = document.querySelectorAll('.accordionData')
for (let heading of accordionHeadings) {
	heading.addEventListener('click', event => {
		let id = (event.target.localName == 'h1') ? event.target.id.slice(4) : event.target.parentElement.id.slice(4)
		let accordionData = $(`#data${id}`)
		let expandArrow = $(`#arrow${id}`)
		if (accordionData.className == 'accordionData extended') {
			// Collapsing the Div
			localStorage.removeItem('activeAccordion')
			accordionData.className = 'accordionData'
			expandArrow.style.transform = 'translateY(-50%) rotate(180deg)'
		}
		else{
			// Extending the Div
			localStorage.activeAccordion = event.target.id
			if (id == 1) {
				$(`#dataIcon${id}`).style.right = '50%'
			}
			else{
				$(`#dataIcon${id}`).style.bottom = '0%'
			}
			for (let ul of accordionDataULs) { ul.className = 'accordionData' }
			for (arrow of expandArrows) { arrow.style.transform = 'translateY(-50%) rotate(180deg)' }
			accordionData.className = 'accordionData extended'
			expandArrow.style.transform = 'translateY(-50%) rotate(0deg)'
		}
	})
} // For loop of Headings
dataIcon1.addEventListener('click', ()=> { manageGatepassMenu.click() })
dataIcon2.addEventListener('click', ()=> { reportsMenu.click() })
dataIcon3.addEventListener('click', ()=> { vouchersMenu.click() })
dataIcon4.addEventListener('click', ()=> { manageBillsMenu.click() })

report1.addEventListener('click', ()=> { loadPage('salesReport') })
report2.addEventListener('click', ()=> { loadPage('purchaseReport') })
report3.addEventListener('click', ()=> { loadPage('companyWiseReports') })

const launch = billNumber => { window.open(`bill/${billNumber}`) }


//  For todo 
const weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
const dateObject = new Date()
const day = dateObject.getDay()
const month = dateObject.getMonth()
const date = dateObject.getDate()
$('#day').innerHTML = weekDays[day]
$('#month').innerHTML = `${months[month]} ${date}`
const addToDoBtn = $(`#addTodo`)
const newTaskInput = $(`#newTaskInput`)
const toggleInput = () => {
	if (newTaskInput.style.display == 'block') {
		newTaskInput.style.transform = 'scaleX(0)'
		addToDoBtn.style.transform = 'rotate(0deg)'
		addToDoBtn.style.color = 'dodgerblue'
		setTimeout(()=>{ newTaskInput.style.display = 'none' }, 100)
	}
	else{
		newTaskInput.style.display = 'block'
		setTimeout(()=>{
			newTaskInput.style.transform = 'scaleX(1)'
			newTaskInput.focus()
			addToDoBtn.style.transform = 'rotate(45deg)'
			addToDoBtn.style.color = 'red'
		}, 100)
	}
}
const saveTask = () =>{
	const saveToDo = new XMLHttpRequest()
	saveToDo.onreadystatechange = function () {
		if (saveToDo.readyState == 4 && saveToDo.status == 200) {
			let newList = JSON.parse(this.responseText)
			$('#todos').scrollTo(0,0)
			printTasks(newList)
			let notifyTask = new Notification(`Task Added`,
			{
				body: `Title: ${newList[newList.length - 1]['title']}`,
				silent: true,
				icon: 'img/shree.png'
			})
			if (soundLoaded) notifySound.play()
		}
	}
	saveToDo.open('POST', 'addTask', true)
	saveToDo.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	saveToDo.send(`title=${newTaskInput.value}&date=${new Date().toLocaleDateString()}`)
	
	newTaskInput.style.transform = 'scaleX(0)'
	addToDoBtn.style.transform = 'rotate(0deg)'
	addToDoBtn.style.color = 'dodgerblue'
	setTimeout(()=>{ newTaskInput.style.display = 'none' }, 100)
	addToDoBtn.removeEventListener('click', toggleInput)
	addToDoBtn.removeEventListener('click', saveTask)
	addToDoBtn.addEventListener('click', toggleInput)

	// If Completed
	newTaskInput.value = ''
}

const deleteTodo = todoId => {
	const deleteTask = new XMLHttpRequest()
	deleteTask.onreadystatechange = function () {
		if (deleteTask.readyState == 4 && deleteTask.status == 200) {
			let newList = JSON.parse(this.responseText)
			printTasks(newList)
		}
	}
	deleteTask.open('POST', 'deleteTask', true)
	deleteTask.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	deleteTask.send(`id=${todoId}`)
}
const taskDone = (todoId, isDone) => {
	const changeIsDone = new XMLHttpRequest()
	changeIsDone.onreadystatechange = function () {
		if (changeIsDone.readyState == 4 && changeIsDone.status == 200) {
			let newList = JSON.parse(this.responseText)
			printTasks(newList)
			$(`[for="todo${todoId}"]`).className = (isDone) ? 'todoTitle checked':'todoTitle'
		}
	}
	changeIsDone.open('POST', 'changeTask', true)
	changeIsDone.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	changeIsDone.send(`id=${todoId}&isDone=${isDone}`)
}
addToDoBtn.addEventListener('click', toggleInput)

newTaskInput.addEventListener('input', event => {
	let todoTitle = newTaskInput.value.trim()
	if (todoTitle != '') {
		addToDoBtn.removeEventListener('click', toggleInput)
		addToDoBtn.style.transform = 'rotate(0deg) rotateX(180deg)'
		addToDoBtn.style.color = 'green'
		addToDoBtn.removeEventListener('click', saveTask)
		addToDoBtn.addEventListener('click', saveTask)
	}
	else{
		addToDoBtn.removeEventListener('click', saveTask)
		addToDoBtn.addEventListener('click', toggleInput)
		addToDoBtn.style.transform = 'rotate(45deg)'
		addToDoBtn.style.color = 'red'
	}
})
const sbSystem = string =>{
	const titleArr = string.split('')
	let output = ''
	let totalStars = 0
	let totalTilds = 0
	for (let char of titleArr) {
		let str = ''
		if (char == '*') {
			str = (totalStars % 2 == 0) ? `<b>`: `</b>` 
			totalStars++
		}
		else if (char == '~') {
			str = (totalTilds % 2 == 0) ? `<i>`: `</i>` 
			totalTilds++
		}
		else{
			str = char
		}
		output += str
	}
	return output
}
// Monthly Statistics
const statisticsWrapper = $(`#statisticsWrapper`)
const navigationLinks = document.querySelectorAll(`#statisticsNav ul a`)
const activeBar = $(`#activeBar`)
const dataRoot = $(`.dataRoot`)
const activeBarPositions = {
	// id:[width(px), 'left Position (%)']
	first:[42,2.4],
	second:[85,16],
	third:[100,38.1],
	fourth:[52,63.5],
	fifth:[90,79]
}
const scrollPositions = {
	first:0,
	second: 495,
	third: 990,
	fourth: 1485,
	fifth: 1980
}

navigationLinks.forEach(link => {
	link.addEventListener('click', event => {
		event.preventDefault()
		if (link.className != 'activeStatistics') {
			let id = event.target.id
			if (!id) id = event.target.parentElement.id
			for (let navLink of navigationLinks) { navLink.className = '' }
			link.className = 'activeStatistics'
			activeBar.style.width = `${activeBarPositions[id][0]}px`
			activeBar.style.left = `${activeBarPositions[id][1]}%`
			dataRoot.scrollTo(scrollPositions[id], 0)
		}
	})
}) // For each for Navigation LIs
dataRoot.scrollTo(0,0)