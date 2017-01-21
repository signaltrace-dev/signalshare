<div class="player" id="player">
    <div v-cloak class="alert alert-danger recording" v-bind:class="{ hidden: !this.recording }" id="alert-recording">
        Recording<img src="/img/recording.gif" alt="" />
    </div>

    <div class="controls" v-cloak>
        <div class="row">
            <div class="col-sm-8 buttons">
                <span class="btn btn-success btn-play-all {{ count($project->tracks) == 0 ? 'hidden' : '' }}" v-bind:class="{ hidden: this.tracksPlaying > 0 || this.recording }" id="btn-play-all"><span>Play</span>&nbsp;<i class="fa fa-play"></i></span>
                <span class="btn btn-danger btn-pause-all" v-bind:class="{ hidden: !this.playing || this.recording }" id="btn-pause-all"><span>Pause</span>&nbsp;<i class="fa fa-pause"></i></span>

                <span class="btn btn-danger btn-record" v-bind:class="{ hidden: (this.recording || this.playing) }" id="btn-record"><span>Record</span>&nbsp;<i class="fa fa-record"></i></span>
                <span class="btn btn-danger btn-record-stop" v-bind:class="{ hidden: !this.recording }" id="btn-record-stop"><span>Stop</span>&nbsp;<i class="fa fa-record"></i></span>
                <span class="btn btn-default btn-metronome" id="btn-metronome"><span>Metronome</span>&nbsp;<i class="fa fa-record"></i></span>

                <div id="metronome" class="metronome hidden">
                    <div id="tempoBox">Tempo: <span id="showTempo">120</span>BPM <input id="tempo" type="range" min="30.0" max="160.0" step="1" value="120" style="height: 20px; width: 200px" onInput="tempo = event.target.value; document.getElementById('showTempo').innerText=tempo;"></div>
                    <div>Resolution:<select onchange="noteResolution = this.selectedIndex;"><option>16th notes<option>8th notes<option>Quarter notes</select></div>
                </div>
            </div>
            <div class="col-sm-4 time">
                <div class="pnl-time" v-text="this.timeDisplay">
                </div>
            </div>
        </div>
    </div>
</div>
