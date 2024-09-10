const left = document.querySelector('.prev')
const right = document.querySelector('.next')
left.style.top = right.style.top = `${(window.innerHeight - 120) / 2}px`

const record = document.querySelectorAll('.note');

const addBtn = document.querySelector('#add')
const deleteBtn = document.querySelector('#delete')
const addbox = document.querySelector('.addbox')
const addFalse = document.querySelector('.false')
const addTrue = document.querySelector('.true')
const recordText = document.querySelector('textarea')
const recordnum = document.querySelector('.text-length')
const reviewtime = document.querySelector('input[type=date]')
const textbox = document.querySelector('.record')

const recordDivs = document.querySelectorAll('.recordbox .note')
if (recordDivs.length >= 3) {
    recordDivs[0].classList.add('textselected-1')
    recordDivs[1].style.left = `${(window.innerWidth - 500) / 2}px`
    recordDivs[1].classList.add('textselected-2')
    recordDivs[2].classList.add('textselected-3')
} else if (recordDivs.length == 2) {
    recordDivs[0].classList.add('textselected-1')
    recordDivs[1].style.left = `${(window.innerWidth - 500) / 2}px`
    recordDivs[1].classList.add('textselected-2')
} else if (recordDivs.length == 1) {
    recordDivs[0].classList.add('textselected-2')
    recordDivs[0].style.left = `${(window.innerWidth - 500) / 2}px`
}

const recordnumber = document.querySelectorAll('.note .recordnum')
const recordTexting = document.querySelectorAll('.note .recordtexting')
for (let i = 0; i < recordnumber.length; i++) {
    recordnumber[i].innerHTML = `${recordTexting[i].value.replace(/\s*/g, "").length}个字符`
}
for (let i = 0; i < recordTexting.length; i++) {
    recordTexting[i].addEventListener('input', () => {
        recordnumber[i].innerHTML = `${recordTexting[i].value.replace(/\s*/g, "").length}个字符`
    })
}

const save = document.querySelectorAll('#saving')
const alterText = document.querySelectorAll('#alterText')
for (let i = 0; i < save.length; i++) {
    save[i].style.display = 'none'
    save[i].addEventListener('click', (e) => {
        save[i].style.display = 'none'
        alterText[i].style.display = 'block'
        recordTexting[i].readOnly = true
        $.ajax({
            type: "POST",
            url: "../reviewRecordChange.php",
            data: {
                i: i,
                text: recordTexting[i].value
            }
        })
    })
    alterText[i].addEventListener('click', (e) => {
        alterText[i].style.display = 'none'
        save[i].style.display = 'block'
        recordTexting[i].readOnly = false
        recordTexting[i].focus()
    })
}

addBtn.addEventListener('click', () => {
    addbox.style.display = 'block'
})

let n = 0
const noteDelBoder = document.querySelector('#delete .border')
const noteDelContent = document.querySelector('#delete .content')
deleteBtn.addEventListener('click', () => {
    const noteDivs = document.querySelectorAll('.recordbox .note')
    if (noteDivs.length != 0) {
        n++
        n = n == 2 ? 0 : 1
        addBtn.style.pointerEvents = n == 0 ? 'auto' : 'none'
        if (n % 2 == 0) {
            noteDelBoder.style.strokeWidth = '8px'
            noteDelContent.classList.remove('btnSelected')
        } else {
            noteDelBoder.style.strokeWidth = '0px'
            noteDelContent.classList.add('btnSelected')
        }
        const noteDelbox = document.querySelectorAll('#noteDelbox')
        for (let i = 0; i < noteDelbox.length; i++) {
            noteDelbox[i].style.opacity = n == 0 ? 0 : 1
            noteDelbox[i].style.pointerEvents = n == 0 ? 'none' : 'auto'
            alterText[i].style.pointerEvents = n == 0 ? 'auto' : 'none'
        }
    }
})
const noteDelbox = document.querySelectorAll('#noteDelbox')
for (let i = 0; i < noteDelbox.length; i++) {
    noteDelbox[i].addEventListener('click', () => {
        $.ajax({
            type: "POST",
            url: "../reviewRecordDelete.php",
            data: {i: i}
        })
        window.location.reload()
    })
}

addFalse.addEventListener('click', () => {
    addbox.style.display = 'none'
    reviewtime.value = ''
    recordText.value = ''
})

reviewtime.addEventListener('input', () => {
    reviewtime.value = reviewtime.value.replace(/\s*/g, "")
})
addTrue.addEventListener('click', () => {
    addbox.style.display = 'none'
    let date = reviewtime.value.replace(/\s*/g, "")
    let text = recordText.value.replace(/\s*/g, "")
    if (text === '') {
        alert('回访情况不能为空！')
        addBtn.click()
    } else {
        $.ajax({
            type: "POST",
            url: "../reviewRecordAdd.php",
            data: {
                reviewtime: date,
                text: text
            }
        })
        reviewtime.value = ''
        recordText.value = ''
        window.location.reload()
    }
})
recordText.addEventListener('input', () => {
    recordnum.innerHTML = `${recordText.value.replace(/\s*/g, "").length}个字符`
})

function rlCommon(x, y) {
    document.querySelector('.textselected-1').classList.remove('textselected-1')
    document.querySelector('.textselected-2').classList.remove('textselected-2')
    document.querySelector('.textselected-3').classList.remove('textselected-3')
    recordDivs[noteKey].classList.add('textselected-1')
    recordDivs[noteKey].style.left = ''
    recordDivs[x].classList.add('textselected-2')
    recordDivs[x].style.left = `${(window.innerWidth - 500) / 2}px`
    recordDivs[y].classList.add('textselected-3')
    recordDivs[y].style.left = ''
}
function rlsCommon() {
    if (noteKey < recordDivs.length - 2) {
        rlCommon(noteKey + 1, noteKey + 2)
    } else if (noteKey == recordDivs.length - 2) {
        rlCommon(noteKey + 1, 0)
    } else if (noteKey == recordDivs.length - 1) {
        rlCommon(0, 1)
    }
}
function setTimeRightCommon(k) {
    recordDivs[k - 1].style.left = '-500px'
    setTimeout(() => {
        recordDivs[k - 1].style.display = 'none'
    }, 300)
    setTimeout(() => {
        right.style.pointerEvents = 'auto'
        recordDivs[k - 1].style.left = ''
        for (let i = 0; i < recordDivs.length; i++) {
        recordDivs[i].style.display = 'block'
        }
    }, 500)
}

function setTimeLeftCommon() {
    recordDivs[noteKey].style.left = ''
    recordDivs[noteKey].style.left = '-500px'
    recordDivs[noteKey].style.transition = ''
    recordDivs[noteKey].style.display = 'none'
    setTimeout(() => {
        recordDivs[noteKey].style.display = 'block'
    }, 10)
    setTimeout(() => {
        left.style.pointerEvents = 'auto'
    }, 500)
}
right.style.pointerEvents = left.style.pointerEvents = record.length < 2 ? 'none' : 'auto'
var noteKey = 0
if (record.length < 3 && noteKey == 0) {
    left.style.pointerEvents = 'none'
}

left.addEventListener('click', () => {
    noteKey--
    const noteDivs = document.querySelectorAll('.recordbox .note')
    noteKey = noteKey < 0 ? noteDivs.length - 1 : noteKey
    if (noteDivs.length > 3) {
        left.style.pointerEvents = 'none'
        if (noteKey == noteDivs.length - 1) {
        setTimeLeftCommon()
        setTimeout(() => {
            noteDivs[noteKey].style.transition = 'all .5s'
            rlCommon(0, 1)
        }, 50)
        } else {
        setTimeLeftCommon()
        setTimeout(() => {
            noteDivs[noteKey].style.transition = 'all .5s'
            rlsCommon()
        }, 50)
        }
    } else if (noteDivs.length < 3) {
        left.style.pointerEvents = 'none'
        right.style.pointerEvents = 'auto'
        document.querySelector('.textselected-2').classList.remove('textselected-2')
        document.querySelector('.textselected-3').classList.remove('textselected-3')
        noteDivs[0].classList.add('textselected-1')
        noteDivs[0].style.left = ''
        noteDivs[1].style.left = `${(window.innerWidth - 500) / 2}px`
        noteDivs[1].classList.add('textselected-2')
    } else if (noteDivs.length == 3)
        rlsCommon()
})

right.addEventListener('click', () => {
    noteKey++
    const noteDivs = document.querySelectorAll('.recordbox .note')
    if (noteDivs.length > 3) {
        right.style.pointerEvents = 'none'
        if (noteKey == noteDivs.length) {
            setTimeRightCommon(noteDivs.length)
            noteKey = 0
            rlCommon(noteKey + 1, noteKey + 2)
        } else {
            setTimeRightCommon(noteKey)
            rlsCommon()
        }
    } else if (noteDivs.length == 3) {
        noteKey = noteKey == noteDivs.length ? 0 : noteKey
        rlsCommon()
    } else {
        right.style.pointerEvents = 'none'
        left.style.pointerEvents = 'auto'
        document.querySelector('.textselected-1').classList.remove('textselected-1')
        document.querySelector('.textselected-2').classList.remove('textselected-2')
        noteDivs[0].classList.add('textselected-2')
        noteDivs[0].style.left = `${(window.innerWidth - 500) / 2}px`
        noteDivs[1].classList.add('textselected-3')
        noteDivs[1].style.left = ''
    }
})