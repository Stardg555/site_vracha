window.addEventListener('DOMContentLoaded', () => {
	const editors = document.querySelectorAll('.vc-visual-editor')

	const init = (editor) => {
		const tables = editor.querySelectorAll('table')
		tables.forEach(table => {
			const div = document.createElement('div')
			div.classList.add('vc-visual-editor__table-wrapper')
			div.innerHTML = table.outerHTML
			table.replaceWith(div)
		})
	}

	editors.forEach(editor => init(editor))
})
