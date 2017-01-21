window.onload = function() {

    // fork getUserMedia for multiple browser versions, for the future
    // when more browsers support MediaRecorder
    navigator.getUserMedia = (navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    if (navigator.getUserMedia) {
        var constraints = {
            audio: true
        };
        var chunks = [];

        // getUserMedia is supported, so let's set up the recorder!
        var onSuccess = function(stream) {
            signalsharePlayer.recorder = new MediaRecorder(stream);

            signalsharePlayer.controls.record.onclick = function() {
                signalsharePlayer.stopAll();

                // Show the recording indicator and hide the Play All button
                signalsharePlayer.recording(true);

                // Play the metronome if it's turned on
                if(signalsharePlayer.metronomeOn){
                    metronome.play();
                }

                // Play any existing tracks while we record
                signalsharePlayer.playAll();
                signalsharePlayer.recorder.start();
            }

            signalsharePlayer.controls.stop.onclick = function() {
                signalsharePlayer.recorder.stop();
                signalsharePlayer.stopAll();


                signalsharePlayer.recording(false);

                if(signalsharePlayer.metronomeOn){
                    metronome.play();
                }
            }

            signalsharePlayer.recorder.onstop = function(e) {
                signalsharePlayer.stopAll();

                var trackNum = (signalsharePlayer.data.tracks) ? signalsharePlayer.data.tracks.length + 1 : 1;
                var clipName = prompt('What do you want to name this track?', 'Track ' + trackNum);

                if(clipName){
                    var blob = new Blob(chunks, {
                        'type': 'audio/ogg; codecs=opus'
                    });
                    chunks = [];
                    var audioURL = window.URL.createObjectURL(blob);

                    var oReq = new XMLHttpRequest();
                    token = document.querySelector('meta[name="csrf-token"]').content;
                    var project = signalsharePlayer.project;
                    var url = '/projects/' + project + '/tracks/upload';

                    oReq.open('POST', url);
                    oReq.setRequestHeader('X-CSRF-TOKEN', token);
                    oReq.setRequestHeader("Content-Type", blob.type);
                    oReq.setRequestHeader("Track-Title", clipName);

                    oReq.onload = function () {
                      if (oReq.status === 200) {
                          var rawResponse = oReq.response;
                          var response = JSON.parse(rawResponse);
                          signalsharePlayer.processUpload(response);
                      }
                    };

                    oReq.send(blob);
                }
                else{
                    chunks = [];
                }
            }

            signalsharePlayer.recorder.ondataavailable = function(e) {
                chunks.push(e.data);
            }
        }

        var onError = function(err) {
            console.log('The following error occured: ' + err);
        }

        navigator.getUserMedia(constraints, onSuccess, onError);
    } else {
        console.log('getUserMedia not supported on your browser!');
    }


}
