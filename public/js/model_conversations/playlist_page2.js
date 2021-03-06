document.addEventListener('DOMContentLoaded', function(event) {

    const firstPlaylistItem = PLAYLIST.globalVariables.playlist.length > 0 ? PLAYLIST.globalVariables.playlist[0] : null;
    let playlist = null;
    let playlist2 = null;

    if(firstPlaylistItem) {
        playlist = new Playlist(firstPlaylistItem.id, firstPlaylistItem.playlist_name, firstPlaylistItem.playlist_img, PLAYLIST.globalVariables.playlist);
        playlist2 = new Playlist(firstPlaylistItem.id, firstPlaylistItem.playlist_name, firstPlaylistItem.playlist_img, PLAYLIST.globalVariables.playlist);
    }

    /**
     * This method update counter element on controls bar
     */
    function updateCounterElement() {
        let counter = document.querySelector('.counter');
        let counterElement = counter.querySelector('.counter-item');

        if(counterElement) {
            counter.removeChild(counterElement);
        }

        let newCounter = playlist2.createDOMCounter();
        counter.appendChild(newCounter);
    }

    (function init() {
        if(playlist) {

            updateCounterElement();

            let tbody = PLAYLIST.DOMElements.playlistTable.querySelector('tbody');

            while(!playlist.items.isEmpty()) {
                let item = playlist.items.front();
                let tr = document.createElement('tr');

                let td_number = document.createElement('td');
                td_number.textContent = item.playlist_order;

                let td_name = document.createElement('td');
                td_name.textContent = item.conv_name;

                let td_gift = document.createElement('td');
                td_gift.textContent = item.gift;

                let td_trainer = document.createElement('td');
                td_trainer.textContent = item.trainer;

                let td_client = document.createElement('td');
                td_client.textContent = item.client;

                let td_audio = document.createElement('td');
                td_audio.innerHTML = "<audio controls><source src=" + PLAYLIST.globalVariables.url + '/' + item.file_name + " type='audio/wav'>Twoja przeglądarka nie obsługuje tego formatu pliku.</audio>";

                tr.appendChild(td_number);
                tr.appendChild(td_audio);
                tr.appendChild(td_name);
                tr.appendChild(td_gift)
                tr.appendChild(td_trainer)
                tr.appendChild(td_client)

                tbody.appendChild(tr);
                playlist.items.dequeue();
            }
        }
    })();

    /**
     * This function set all tbody rows color
     * @param color
     */
    function setAllRowsColor(color) {
        let rows = PLAYLIST.DOMElements.playlistTable.querySelectorAll('tbody tr');
        if(rows) {
            rows.forEach(row => {
                row.style.backgroundColor = color;
            });
        }
    }

    function globalClickHandler(e) {
        const clickedElement = e.target;

        if(playlist2) {
            if(clickedElement.matches(".glyphicon-play")) { //click on play icon
                playlist2.play();
            }
            else if(clickedElement.matches('.glyphicon-forward')) { //click on forward icon
                let prevState = playlist2.state;
                playlist2.pause();
                setAllRowsColor('white');
                playlist2.updateCounter('forward');
                updateCounterElement();
                if(prevState == 2) {
                    playlist2.play();
                }
            }
            else if(clickedElement.matches('.glyphicon-backward')) { //click on backward icon
                let prevState = playlist2.state;
                playlist2.pause();
                setAllRowsColor('white');
                playlist2.updateCounter('backward');
                updateCounterElement();
                if(prevState == 2) {
                    playlist2.play();
                }
            }
            else if(clickedElement.matches('.glyphicon-stop')) { //click on stop icon
                playlist2.stop();
                setAllRowsColor('white');
                updateCounterElement();
            }
            else if(clickedElement.matches('.glyphicon-pause')) {
                playlist2.pause();
            }
        }
    }

    function endedHandler(e) {
        if(playlist2.state === 2) { //playlist is in play state
            let result = playlist2.updateCounter('forward');

            if(result === true) { //next conversation
                setTimeout(() => {
                    playlist2.play();
                },1000);
            }
            else if(result === false) { //error
                console.log('cos zlego sie dzieje');
            }
            else { //end playlist
                console.log('Koniec playlisty');
                let lastRow = PLAYLIST.DOMElements.playlistTable.querySelector('tbody tr:last-of-type');
                setTimeout(() => {
                    lastRow.style.backgroundColor = 'white';
                }, 1000)
                playlist2.setState(0);
            }

            setTimeout(() => {
                updateCounterElement();
            }, 1000)
        }
    }

    let audioElements = document.querySelectorAll('audio');

    audioElements.forEach(audio => {
        audio.addEventListener('ended', endedHandler);
    });

    document.addEventListener('click', globalClickHandler);




});