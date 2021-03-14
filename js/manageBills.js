const qs = selector => document.querySelector(selector)
const qsa = selector => document.querySelectorAll(selector)
const print = billNumber => window.open(`bill/${billNumber}`,'_blank')
const addBillBtn = qs('#addNewBtn')
const newManualBill = qs('#manualBill')
const billNumber = qsa('.billNumber')
const companyName = qsa('.companyName')
const gatepassNumber = qsa('.gatepassNumber')
const billDate = qsa('.billDate')
const searchBox = qs('#searchInput')
const html = qs('html')

qs('#searchIcon').addEventListener('click', () => searchInput.focus())
addBillBtn.onclick = () => window.location.href = 'newBill'
newManualBill.onclick = () => window.location.href = 'newManualBill'
searchBox.oninput = () => {
	let query = searchBox.value.toLowerCase().trim()
	for (var i = 0; i < companyName.length; i++) {
		if ((companyName[i].innerText.toLowerCase().indexOf(query) == -1)) {
				companyName[i].parentElement.style.display = 'none'
				if (gatepassNumber[i].innerText.toLowerCase().indexOf(query) == -1) {
					gatepassNumber[i].parentElement.style.display = 'none'
					if (billNumber[i].innerText.toLowerCase().indexOf(query) == -1) {
							billNumber[i].parentElement.style.display = 'none'
							if (billDate[i].innerText.toLowerCase().indexOf(query) == -1) {
								billDate[i].parentElement.style.display = 'none'
							}
							else{
								billDate[i].parentElement.style.display = 'table-row'
							}
					}
					else{
						billNumber[i].parentElement.style.display = 'table-row'
					}
				}
				else{
					gatepassNumber[i].parentElement.style.display = 'table-row'
				}
		}
		else{
			companyName[i].parentElement.style.display = 'table-row'
		}
	} //
}
html.onkeydown = event => {
	if (event.key == 's' && event.altKey) searchBox.focus()
	if (event.key == 'n' && event.altKey) addNewBtn.click() 
}

const edit = (billNumber, oldDate) => {
	viewPopup.click()
	qs('#table').innerHTML = 
	`<thead>
		<tr>
			<td colspan="3">
				<h1>Change Bill Date</h1>
			</td>
		</tr>
	</thead>
	<tbody id="editBody">
		<tr>
			<td>Bill Number</td>
			<td style="text-align: center;"><b id="billNumberToUpdate"></b></td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: left;">Date</td>
			<td style="text-align: center;"><input type="date" value="" id="updatedDate" /></td>
			<td><button type="submit" class="smallButton" id="saveDate">Save</button></td>
		</tr>
		<tr>
			<td colspan="3"  style="text-align: center;">
				<button class="smallButton" id="updateEntireBill">Update Entire Bill Details</button>
			</td>
		</tr>
	</tbody>`

	updatedDate = qs('#updatedDate')
	saveDate = qs('#saveDate')
	updatedDate.value = oldDate
	qs('#billNumberToUpdate').innerText = billNumber
	qs('#updateEntireBill').addEventListener('click', function () {
		window.location.href = `editBill/${billNumber}`
	})
	saveDate.onclick = () => {
		if (updatedDate.value == '') 
			updatedDate.focus()
		else if (updatedDate.value == oldDate) 
			updatedDate.focus()
		else{
			saveDate.disabled = true
			saveDate.innerText = 'Saving...'
			let updateDate = new XMLHttpRequest()
			updateDate.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if (this.responseText === 'DONE') {
						saveDate.innerText = 'Saved'
						saveDate.style.backgroundColor = 'green'
						setTimeout(() => {
							dismissBtn.click()
							setTimeout(() => {
								window.location.reload()
							}, 200)
						}, 500)
					}
				}
			}
			updateDate.open("POST", `updateBillDate`, true)
			updateDate.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
			updateDate.send(`billNumber=${billNumber}&newDate=${updatedDate.value}`)
		}
	}
}

let changeStatus = (billNumber, remarks, billStatus) => {
	viewPopup.click()
	let valid = ''
	let invalid = ''
	if (billStatus == 1)
		valid = 'checked'
	else
		invalid = 'checked'
	qs('#table').innerHTML = 
	`<thead>
		<tr>
			<td colspan="3">
				<h1>Bill Status</h1>
			</td>
		</tr>
	</thead>
	<tbody id="editBody">
		<tr class="noHover">
			<td style="text-align: center;" colspan="3">
				<input type="radio" name="status" id="valid" ${valid} />
				<label for="valid" class="valid"><img src="icon/checkedCircle" /></label>
				<input type="radio" name="status" id="invalid" ${invalid} />
				<label for="invalid" class="invalid"><img src="icon/warning" /></label>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="text-align: center;"><textarea id="remarks" placeholder="Remarks" cols="40" rows="3">${remarks}</textarea></td>
		</tr>
		<tr class="noHover">
			<td colspan="3"  style="text-align: center;">
				<button class="smallButton" id="changeStatus">Save</button>
			</td>
		</tr>
	</tbody>`
	const saveBtn = qs('#changeStatus')
	saveBtn.onclick = event => {
		event.preventDefault()
		let isValid = (qs('#valid').checked) ? true:false;
		let remarks = qs('#remarks').value
		saveBtn.disabled = true
		saveBtn.innerText = 'Saving...'
		let updateStts = new XMLHttpRequest()
		updateStts.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText === 'DONE') {
					saveBtn.innerText = 'Saved'
					saveBtn.style.backgroundColor = 'green'
					setTimeout(() => {
						dismissBtn.click()
						setTimeout(() => {	window.location.reload()	}, 200)
					}, 500)
				}
				else{
					saveBtn.style.backgroundColor = 'red'
					saveBtn.innerText = this.responseText
					setTimeout(() => { window.location.reload() }, 2000)
				}
			}
		}
		updateStts.open("POST", `updateBillStatus`, true)
		updateStts.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		updateStts.send(`billNumber=${billNumber}&billStatus=${isValid}&remarks=${remarks}`)
	} // On click function of Save Button
} // Change Status Function

let dismissBtn = qs('#dismiss')
let viewPopup = qs('#view')
let popupBox = qs('#popupBox')
let content = qs('#content')
viewPopup.onclick = () => {
	popupBox.style.display = 'inline-block'
	setTimeout(() => { popupBox.style.opacity = 1 }, 200)
	setTimeout(() => { content.style.transform = 'translate(-50%,-50%) scale(1)' }, 300)
}
dismissBtn.onclick = () => {
	content.style.transform = 'translate(-50%,-50%) scale(0)'
	setTimeout(() => {
		popupBox.style.opacity = 0
		popupBox.style.display = 'none'
	}, 200)
}
window.onclick = event => { if (event.target == popupBox) dismissBtn.click() }
window.onkeydown = event => { if (event.key == 'Escape') dismissBtn.click() }