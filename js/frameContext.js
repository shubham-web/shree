document.addEventListener('contextmenu', event => {
	event.preventDefault()
	window.parent.contextMenu.style.top = `${event.clientY + window.parent.header.clientHeight + 25}px`
	window.parent.contextMenu.style.left = `${event.clientX + window.parent.sidebarMenu.clientWidth +5}px`
	window.parent.showContext()
})
document.addEventListener('click', event => {
	window.parent.hideContext()
})