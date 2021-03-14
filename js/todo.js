const qs = selector => document.querySelector(selector)
const printTasks = list => {
	let todoList = new Set()
	qs(`#todos`).innerHTML = ''
	if (list.length == 0) {
		qs(`#todos`).innerHTML = '<h1 id="emptyToDo">No Tasks  🎉</h1><small class="infoText">Click on Add (+) Button to add new Tasks</small>'
		qs(`#undoneTasks`).innerHTML = `${list.length} Tasks`
	}
	else{
		const undoneTasks = list.filter(item => !item.isDone)
		qs(`#undoneTasks`).innerHTML = `${undoneTasks.length} Tasks`
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
			qs(`#todos`).innerHTML += todoComponent

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
const weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
const dateObject = new Date()
const day = dateObject.getDay()
const month = dateObject.getMonth()
const date = dateObject.getDate()
qs('#day').innerHTML = weekDays[day]
qs('#month').innerHTML = `${months[month]} ${date}`
const addToDoBtn = qs(`#addTodo`)
const newTaskInput = qs(`#newTaskInput`)
const toggleInput = () => {
	if (newTaskInput.style.display == 'block') {
		newTaskInput.style.transform = 'scaleX(0)'
		addToDoBtn.style.transform = 'rotate(0deg)'
		addToDoBtn.style.color = 'dodgerblue'
		setTimeout(()=>{
			newTaskInput.style.display = 'none'
		}, 100)
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
			printTasks(newList)
			let notifyTask = new Notification(`Task Added`,
			{
				body: `Title: ${newList[newList.length - 1]['title']}`,
				silent: true,
				icon: 'img/shree.png'
			})
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
			qs(`[for="todo${todoId}"]`).className = (isDone) ? 'todoTitle checked':'todoTitle'
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
window.addEventListener('load', () => {
	fetch(`tasksToDo.json`)
	.then(response => response.json())
	.then(jsonTodos => { printTasks(jsonTodos) })
	.catch(error => console.error('Error:', error))
})