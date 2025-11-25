// const startBtn = document.getElementById("start");
// const statusEl = document.getElementById("status");
// const waveform = document.getElementById("waveform");
// const waveformBars = document.querySelectorAll(".bar");
// const micShadow = document.querySelector(".mic-shadow");

// function setWaveform(state) {
//     switch (state) {
//         case "user":
//             waveform.style.visibility = "visible";
//             startBtn.style.background = "radial-gradient(circle, #00e5ff, #00bcd4)";
//             micShadow?.classList.add("glow-user");
//             micShadow?.classList.remove("glow-ai", "bounce-ai");
//             waveformBars.forEach((bar, i) => {
//                 bar.style.backgroundColor = `hsl(${190 + i * 10}, 100%, 60%)`;
//                 bar.style.animation = `heartbeat 1s infinite`;
//                 bar.style.opacity = "1";
//             });
//             break;

//         case "ai":
//             waveform.style.visibility = "visible";
//             startBtn.style.background = "radial-gradient(circle, #ff4081, #ff80ab)";
//             micShadow?.classList.add("glow-ai", "bounce-ai");
//             micShadow?.classList.remove("glow-user");
//             waveformBars.forEach((bar, i) => {
//                 bar.style.backgroundColor = `hsl(${330 + i * 5}, 90%, 70%)`;
//                 bar.style.animation = `bounce 0.8s infinite ease-in-out`;
//                 bar.style.opacity = "1";
//             });
//             break;

//         case "off":
//             waveform.style.visibility = "hidden";
//             startBtn.style.background = "radial-gradient(circle, #00e5ff, #00bcd4)";
//             micShadow?.classList.remove("glow-user", "glow-ai", "bounce-ai");
//             waveformBars.forEach(bar => {
//                 bar.style.animation = "none";
//                 bar.style.opacity = "0.5";
//             });
//             break;
//     }
// }

// startBtn.onclick = () => {
//     startBtn.disabled = true;
//     statusEl.textContent = "AI Speaking…";
//     setWaveform("ai");

//     const hrAudio = new Audio('/api/hr-first');
//     hrAudio.play();
//     hrAudio.onended = () => beginRecording();
// };

// function beginRecording() {
//     if (isInterviewComplete) return;

//     statusEl.textContent = "AI Listening…";
//     setWaveform("user");

//     navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
//         const audioContext = new AudioContext();
//         const input = audioContext.createMediaStreamSource(stream);
//         const analyser = audioContext.createAnalyser();
//         input.connect(analyser);
//         analyser.fftSize = 2048;
//         const dataArray = new Uint8Array(analyser.fftSize);

//         const options = MediaRecorder.isTypeSupported("audio/webm;codecs=opus")
//             ? { mimeType: "audio/webm;codecs=opus" }
//             : {};

//         const recorder = new MediaRecorder(stream, options);
//         const chunks = [];
//         let silenceCounter = 0;
//         const silenceThreshold = 0.01;
//         const maxSilenceFrames = 30;

//         recorder.ondataavailable = e => {
//             if (e.data.size > 0) chunks.push(e.data);
//         };

//         recorder.start();

//         // Silence detection after 5s
//         setTimeout(() => {
//             function monitor() {
//                 analyser.getByteTimeDomainData(dataArray);
//                 let sum = 0;
//                 for (let i = 0; i < dataArray.length; i++) {
//                     const val = (dataArray[i] - 128) / 128;
//                     sum += val * val;
//                 }
//                 const volume = Math.sqrt(sum / dataArray.length);

//                 if (volume < silenceThreshold) {
//                     silenceCounter++;
//                 } else {
//                     silenceCounter = 0;
//                 }

//                 if (silenceCounter > maxSilenceFrames) {
//                     recorder.stop();
//                     stream.getTracks().forEach(track => track.stop());
//                 } else {
//                     requestAnimationFrame(monitor);
//                 }
//             }
//             monitor();
//         }, 5000);

//         recorder.onstop = async () => {
//             setWaveform("off");

//             const blob = new Blob(chunks, { type: 'audio/webm' });
//             if (blob.size < 4000) {
//                 alert("⚠️ No sound detected. Please speak clearly.");
//                 statusEl.textContent = "Click Start Again";
//                 startBtn.disabled = false;
//                 return;
//             }

//             const formData = new FormData();
//             formData.append('audio', blob, 'audio.webm');
//             statusEl.textContent = "Processing…";

//             try {
//                 const res = await fetch('/api/speak', { method: 'POST', body: formData });

//                 // 🔹 Check X-Interview-Complete header (newly added)
//                 if (res.headers.get("X-Interview-Complete") === "true") {
//                     console.log("Interview completed from header!");
//                     isInterviewComplete = true;
//                 }

//                 const aiReplyBlob = await res.blob();
//                 const aiReplyUrl = URL.createObjectURL(aiReplyBlob);
//                 const aiReplyAudio = new Audio(aiReplyUrl);

//                 aiReplyAudio.onloadedmetadata = () => {
//                     statusEl.textContent = "AI Speaking…";
//                     setWaveform("ai");
//                     aiReplyAudio.play();
//                 };

//                 aiReplyAudio.onended = async () => {
//                     setWaveform("off");

//                     if (isInterviewComplete) {
//                         statusEl.textContent = "Interview Completed ✅";
//                         startBtn.disabled = true;
//                         waveform.style.visibility = "hidden";
//                         setTimeout(() => window.location.href = "/result", 2000);
//                     } else {
//                         beginRecording();
//                     }
//                 };
//             } catch (err) {
//                 console.error("Fetch error:", err);
//                 alert("⚠️ Network error, please try again.");
//                 statusEl.textContent = "Click Start Again";
//                 startBtn.disabled = false;
//                 setWaveform("off");
//             }
//         };
//     }).catch(err => {
//         console.error("Microphone error:", err);
//         alert("⚠️ Microphone access is required.");
//         statusEl.textContent = "Click Start Again";
//         startBtn.disabled = false;
//         setWaveform("off");
//     });
// }

// let isInterviewComplete = false;
const startBtn = document.getElementById("start");
const statusEl = document.getElementById("status");
const waveform = document.getElementById("waveform");
const waveformBars = document.querySelectorAll(".bar");
const micShadow = document.querySelector(".mic-shadow");

function setWaveform(state) {
    switch (state) {
        case "user":
            waveform.style.visibility = "visible";
            startBtn.style.background = "radial-gradient(circle, #00e5ff, #00bcd4)";
            micShadow?.classList.add("glow-user");
            micShadow?.classList.remove("glow-ai", "bounce-ai");
            waveformBars.forEach((bar, i) => {
                bar.style.backgroundColor = `hsl(${190 + i * 10}, 100%, 60%)`;
                bar.style.animation = `heartbeat 1s infinite`;
                bar.style.opacity = "1";
            });
            break;

        case "ai":
            waveform.style.visibility = "visible";
            startBtn.style.background = "radial-gradient(circle, #ff4081, #ff80ab)";
            micShadow?.classList.add("glow-ai", "bounce-ai");
            micShadow?.classList.remove("glow-user");
            waveformBars.forEach((bar, i) => {
                bar.style.backgroundColor = `hsl(${330 + i * 5}, 90%, 70%)`;
                bar.style.animation = `bounce 0.8s infinite ease-in-out`;
                bar.style.opacity = "1";
            });
            break;

        case "off":
            waveform.style.visibility = "hidden";
            startBtn.style.background = "radial-gradient(circle, #00e5ff, #00bcd4)";
            micShadow?.classList.remove("glow-user", "glow-ai", "bounce-ai");
            waveformBars.forEach(bar => {
                bar.style.animation = "none";
                bar.style.opacity = "0.5";
            });
            break;
    }
}

startBtn.onclick = () => {
    startBtn.disabled = true;
    statusEl.textContent = "AI Speaking…";
    setWaveform("ai");

    const hrAudio = new Audio('/api/hr-first');
    hrAudio.play();
    hrAudio.onended = () => beginRecording();
};

function beginRecording() {
    if (isInterviewComplete) return;

    statusEl.textContent = "AI Listening…";
    setWaveform("user");

    navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
        const audioContext = new AudioContext();
        const input = audioContext.createMediaStreamSource(stream);
        const analyser = audioContext.createAnalyser();
        input.connect(analyser);
        analyser.fftSize = 2048;
        const dataArray = new Uint8Array(analyser.fftSize);

        const options = MediaRecorder.isTypeSupported("audio/webm;codecs=opus")
            ? { mimeType: "audio/webm;codecs=opus" }
            : {};

        const recorder = new MediaRecorder(stream, options);
        const chunks = [];
        let silenceCounter = 0;
        const silenceThreshold = 0.01;
        const maxSilenceFrames = 30;

        recorder.ondataavailable = e => {
            if (e.data.size > 0) chunks.push(e.data);
        };

        recorder.start();

        // Silence detection after 5s
        setTimeout(() => {
            function monitor() {
                analyser.getByteTimeDomainData(dataArray);
                let sum = 0;
                for (let i = 0; i < dataArray.length; i++) {
                    const val = (dataArray[i] - 128) / 128;
                    sum += val * val;
                }
                const volume = Math.sqrt(sum / dataArray.length);

                if (volume < silenceThreshold) {
                    silenceCounter++;
                } else {
                    silenceCounter = 0;
                }

                if (silenceCounter > maxSilenceFrames) {
                    recorder.stop();
                    stream.getTracks().forEach(track => track.stop());
                } else {
                    requestAnimationFrame(monitor);
                }
            }
            monitor();
        }, 5000);

        recorder.onstop = async () => {
            setWaveform("off");

            const blob = new Blob(chunks, { type: 'audio/webm' });
            if (blob.size < 4000) {
    alert("⚠️ No sound detected. Please speak clearly.");
    statusEl.textContent = isInterviewComplete
        ? "Interview Completed ✅"
        : "Click Start Again";
    startBtn.disabled = isInterviewComplete;
    return;
}


            const formData = new FormData();
            formData.append('audio', blob, 'audio.webm');
            statusEl.textContent = "Processing…";

            try {
                const res = await fetch('/api/speak', { method: 'POST', body: formData });

// ✅ MUST be before res.blob()
const isFinal = res.headers.get('X-Interview-Complete') === 'true';
console.log("Header X-Interview-Complete:", res.headers.get("X-Interview-Complete"));
const aiReplyBlob = await res.blob();
const aiReplyUrl = URL.createObjectURL(aiReplyBlob);
const aiReplyAudio = new Audio(aiReplyUrl);

aiReplyAudio.onloadedmetadata = () => {
    statusEl.textContent = "AI Speaking…";
    setWaveform("ai");
    aiReplyAudio.play();
};

aiReplyAudio.onended = async () => {
    setWaveform("off");

    if (isFinal) {
        console.log("✅ Interview marked complete: stopping everything");
        isInterviewComplete = true;
        statusEl.textContent = "Interview Completed ✅";
        startBtn.disabled = true;
        waveform.style.visibility = "hidden";

        setTimeout(() => window.location.href = "/result", 2000);
    } else {
        beginRecording();
    }
};



            } catch (err) {
                console.error("Fetch error:", err);
                alert("⚠️ Network error, please try again.");
                statusEl.textContent = "Click Start Again";
                startBtn.disabled = false;
                setWaveform("off");
            }
        };
    }).catch(err => {
        console.error("Microphone error:", err);
        alert("⚠️ Microphone access is required.");
        statusEl.textContent = "Click Start Again";
        startBtn.disabled = false;
        setWaveform("off");
    });
}

let isInterviewComplete = false;
