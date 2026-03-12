import React from 'react'
import ReactDOM from 'react-dom'
import Record from '../../jsx/Record/index.jsx'
window.addEventListener('DOMContentLoaded', async () => {
  const domElement = document.querySelector("#record-component");
	if (!domElement) return

	const props = {
		// departmentId: getParams.departmentId,
		doctorId: domElement.dataset.doctorId,
	}

  const e = React.createElement;
  ReactDOM.render(e(Record, props), domElement);
})

