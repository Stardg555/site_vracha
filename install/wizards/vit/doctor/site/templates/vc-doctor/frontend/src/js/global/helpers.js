export const templatePath = '/local/templates/vc-site'

export const getNoun = ( val, one, two, five,) => {
	let n = Math.abs(val)
	n %= 100
	if (n >= 5 && n <= 20) {
		return five
	}
	n %= 10
	if (n === 1) {
		return one
	}
	if (n >= 2 && n <= 4) {
		return two
	}
	return five
}

export const getGETParams = (string = null) => {
	if (!string) string = window.location.search
	string = decodeURI(string)
	let queryDict = {}
    if (!!string) {
        string
            .substr(1)
            .split('&')
            .forEach(function (item) {
                queryDict[item.split('=')[0]] = item.split('=')[1]
            })
    }
	return queryDict
}

export const get = async (params) => {
	const sessid = BX.bitrix_sessid()
	let url = `/bitrix/services/main/ajax.php?SITE_ID=s1&sessid=${sessid}`
	for (const prop in params) {
		url += `&${prop}=${params[prop]}`
	}
	return new Promise(async (resolve, reject) => {
		const response = await fetch(url)
		const json = await response.json()
		// console.log(json)
		if (json.status === 'success') {
			resolve(json.data)
		}
		if (json.status === 'error') {
			reject(json.errors)
		}
	})
}
