function generateIcsFile(event) {
    const { title, description, start, end, location } = event

    const icsContent = `BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Your Company//Your App//EN
CALSCALE:GREGORIAN
BEGIN:VEVENT
UID:${Math.random().toString(36).substring(2, 15)}
DTSTART:${formatDate(start)}
DTEND:${formatDate(end)}
SUMMARY:${title}
DESCRIPTION:${description}
LOCATION:${location}
END:VEVENT
END:VCALENDAR`
    return icsContent
}

function formatDate(date) {
    const year = date.getFullYear()
    const month = String(date.getMonth() + 1).padStart(2, '0')
    const day = String(date.getDate()).padStart(2, '0')
    const hours = String(date.getHours()).padStart(2, '0')
    const minutes = String(date.getMinutes()).padStart(2, '0')
    const seconds = String(date.getSeconds()).padStart(2, '0')
    console.log(hours)
    return `${year}${month}${day}T${hours}${minutes}${seconds}`
}

function downloadIcsFile(event) {
      const icsContent = generateIcsFile(event);
      const blob = new Blob([icsContent], { type: 'text/calendar' });
      const url = URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.download = `${event.title.replace(/\s/g, '_')}.ics`;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
}

export default downloadIcsFile
