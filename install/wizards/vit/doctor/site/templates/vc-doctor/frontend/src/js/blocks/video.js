window.addEventListener('DOMContentLoaded', () => {

    //video
    const videoContainers = document.querySelectorAll('.vc-video')

    const initVideo = (container) => {
        const video = container.querySelector('.vc-video__vid')
        const triggerBtn = container.querySelector('.vc-video__controls')
        const poster = container.querySelector('.vc-video__poster')
        const activeCls = 'vc-video__controls--play'

        const playVideo = () => {
            video.muted = false
            if (poster) poster.style.display = 'none'
            video.play()
            triggerBtn.classList.add(activeCls)
        }
        const stopVideo = () => {
            if (poster) poster.style.display = 'block'
            video.pause()
            video.currentTime = 0
            triggerBtn.classList.remove(activeCls)
        }

        document.addEventListener("fullscreenchange", () => {
            if (!document.fullscreenElement) {
                stopVideo()
            }
        });

        video.addEventListener("webkitendfullscreen", stopVideo)

        video.addEventListener("canplay", () => {
            video.muted = true
            if (video.autoplay) {
                video.pause()
            }
        });

        triggerBtn.addEventListener('click', () => {
            triggerBtn.classList.contains(activeCls) ? stopVideo() : playVideo()
        })

        video.addEventListener('ended', stopVideo)
    }

    if (videoContainers.length !== 0) {
        videoContainers.forEach(v => initVideo(v))
    }
})

