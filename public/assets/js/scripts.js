function qsa(div) {
    return document.querySelectorAll(div);
}
function qs(div) {
    return document.querySelector(div);
}
function on(el) {
    el.classList.add("active");
}
function off(el) {
    el.classList.remove("active");
}

let f = 0,
    t = 0,
    l = 0,
    scr_offset = 400,
    s_speed = 120,
    scr = false,
    vw = window.innerWidth,
    vh = window.innerHeight,
    s_t = 0,
    w_h = 0,
    scrollvel = 0,
    stopall = false;
const startdelay = 300;
let maxsections = document.querySelectorAll("aaa-s").length;

let tdv =
    navigator.maxTouchPoints || "ontouchstart" in document.documentElement;
if (tdv > 0) {
    tdv = true;
}
if (tdv > 0 && notmob == false) {
    tdv = true;
} else {
    tdv = false;
}

function set_rh() {
    if (tdv) {
        const realh = vh - qs("#rh").clientHeight;
        document.documentElement.style.setProperty("--rh", realh + "px");
    }
}

set_rh();

let sid = 1;
qsa("aaa-s").forEach((el) => {
    el.setAttribute("s-id", sid);
    sid++;
});

sid = 1;
qsa("aaa-s-inner").forEach((el) => {
    el.setAttribute("s-id", sid);
    el.id = "aaa-s-inner_" + sid;
    sid++;
});

function ValidateEmail(mail) {
    if (
        /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(
            mail
        )
    ) {
        return true;
    } else {
        return false;
    }
}

function readc(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(";");
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == " ") c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) {
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
        }
    }
    return null;
}

if (qsa(".accept_cookies").length > 0) {
    qs(".accept_cookies").addEventListener("click", (e) => {
        let expiresdate = new Date(2068, 1, 02, 11, 20);
        let cookievalue = "ok";
        document.cookie =
            "cookiepolicy=" +
            encodeURIComponent(cookievalue) +
            "; expires=" +
            expiresdate.toUTCString() +
            "; path=/;";
        qs(".cookies_notification").classList.remove("active");
        launchpopup();
    });
}

if (readc("cookiepolicy") != "ok") {
    qs(".cookies_notification").classList.add("active");
}

function launchpopup() {
    if (readc("cookiepolicy") == "ok") {
        setTimeout(() => {
            if (!qs("#view_hubber")) {
                qs(".popup_wr").classList.add("active");
            }
        }, 1000);
    }
}

function main() {
    scr = true;

    // transition out

    qs("#transition").classList.add("started");

    qsa("a").forEach((a) => {
        a.addEventListener("click", function (e) {
            const link = a.getAttribute("href");
            if (
                a.getAttribute("target") != "_blank" &&
                link.includes("mailto:") == false
            ) {
                if (link != "#") {
                    setTimeout(function () {
                        window.location = link;
                    }, 1200);
                    qs("#transition").classList.add("prepared");
                    setTimeout(() => {
                        qs("#transition").classList.remove(
                            "prepared",
                            "started"
                        );
                    }, 20);
                    stopall = true;
                }
                e.preventDefault();
            }
        });
    });

    // on start

    setTimeout(() => {
        qs("#app").style.opacity = 1;
        document.body.classList.add("loaded");
        launchpopup();
    }, startdelay);

    // popup

    qs(".popup_wr .close_btn").addEventListener("click", () => {
        qs(".popup_wr").classList.remove("active");
        setTimeout(() => {
            launchpopup();
        }, 60000);
    });

    // resize

    function resize() {
        vw = window.innerWidth;
        vh = window.innerHeight;
        set_rh();
        getSectionsSize();
    }

    window.addEventListener("resize", (e) => {
        resize();
    });

    // scrolling

    let unbtimer;
    function onscroll() {
        clearTimeout(unbtimer);
        const blockelement = qs("#aaa-block");
        if (!blockelement.classList.contains("noh")) {
            blockelement.classList.add("on");
        }
        unbtimer = setTimeout(function () {
            blockelement.classList.remove("on");
        }, 500);
    }

    if (!tdv) {
        window.addEventListener("wheel", function (e) {
            let delta = -e.deltaY;
            let deltax = -e.deltaX;
            if (Math.abs(deltax) > Math.abs(delta)) {
                delta = deltax;
            }
            let s_n = 0;
            if (navigator.userAgent.toLowerCase().indexOf("firefox") > -1) {
                s_n = delta * 23;
            } else {
                s_n = delta / 1.5;
            }
            if (s_n > 500) {
                s_n = 500;
            } else if (s_n < -500) {
                s_n = -500;
            }
            if (scr == true) {
                f += s_n;
                onscroll();
            }
        });
    }

    // Sections

    class section {
        constructor(sectionid, div, innerdiv) {
            this.id = sectionid;
            this.div = div;
            this.innerdiv = innerdiv;
            this.top;
            this.bottom;
            this.height;
            this.type;
        }

        setType() {
            if (this.div.getAttribute("type")) {
                this.type = this.div.getAttribute("type");
            } else {
                this.type = "vertical";
            }
        }

        checkPos() {
            this.top = this.div.getBoundingClientRect().top + t;
            this.bottom = this.div.getBoundingClientRect().bottom + t;
        }

        updatePos() {
            if (this.type == "vertical") {
                this.innerdiv.style.transform = "translate3d(0," + t + "px,0)";
            } else if (this.type == "pin") {
                if (this.top >= 0) {
                    this.innerdiv.style.transform =
                        "translate3d(0," + t + "px,0)";
                } else if (this.top <= 0 && this.bottom >= vh) {
                    this.innerdiv.style.transform = "translate3d(0,-100vh,0)";
                } else if (this.bottom < vh) {
                    const relative_t = t + this.height - vh;
                    this.innerdiv.style.transform =
                        "translate3d(0," + relative_t + "px,0)";
                }
            }
        }

        calcSize() {
            this.height = this.innerdiv.clientHeight;
        }
    }

    function createSections() {
        let step = 1;
        document.querySelectorAll("aaa-s").forEach((ss) => {
            window["ss_" + step] = new section(
                step,
                ss,
                ss.querySelector("aaa-s-inner")
            );
            const object = window["ss_" + step];
            object.updatePos();
            object.setType();
            step++;
        });
    }
    createSections();

    function getSectionsSize() {
        for (let i = 1; i <= maxsections; i++) {
            window["ss_" + i].calcSize();
        }
    }
    getSectionsSize();

    if (!tdv) {
        function restartsections() {
            for (let i = 1; i <= maxsections; i++) {
                window["ss_" + i].updatePos();
            }
        }
        setInterval(() => {
            requestAnimationFrame(restartsections);
        }, 4000);
    }
    // scroll base

    if (!tdv) {
        function w_h_calc() {
            w_h = -vh;
            document.querySelectorAll("aaa-s").forEach((section) => {
                w_h += section.clientHeight;
            });
        }

        setInterval(() => {
            w_h_calc();
        }, 200);

        function trdata() {
            if (f >= 0) {
                f = 0;
            }
            if (f <= -w_h) {
                f = -w_h + 1;
            }

            let e = (f - t) / 20;
            if (e > s_speed) {
                e = s_speed;
            } else if (e < -s_speed) {
                e = -s_speed;
            }
            if (t > f) {
                if (t - f > 0.01) {
                    t = t - 0.01 + 2 * e;
                }
            } else {
                if (f - t > 0.01) {
                    t = t + 0.01 + 2 * e;
                }
            }

            l += (t - l) * 0.1;
            r = Math.round(l * 100) / 100;

            const diff = t - r;
            const acc = diff / vh;
            scrollvel = +acc;

            requestAnimationFrame(trdata);
        }
        setTimeout(() => {
            trdata();
        }, startdelay);

        // Scroll resolution

        function scrll() {
            for (let i = 1; i <= maxsections; i++) {
                const ss = window["ss_" + i];
                ss.checkPos();
                if (ss.top <= vh + scr_offset && ss.bottom >= -scr_offset) {
                    ss.updatePos();
                    const type = ss.type;
                    if (type == "pin") {
                        const pinstep = parseInt(-ss.top / vh);
                        if (pinstep == 0 || pinstep < 0) {
                            document.querySelector(
                                "#mission_topcolor"
                            ).classList = "state_0";
                            document
                                .querySelector(".msn_info_0")
                                .classList.add("active");
                            document
                                .querySelector(".msn_info_1")
                                .classList.remove("active");
                            document
                                .querySelector(".msn_info_2")
                                .classList.remove("active");
                        } else if (pinstep == 1) {
                            document.querySelector(
                                "#mission_topcolor"
                            ).classList = "state_1";
                            document
                                .querySelector(".msn_info_0")
                                .classList.remove("active");
                            document
                                .querySelector(".msn_info_1")
                                .classList.add("active");
                            document
                                .querySelector(".msn_info_2")
                                .classList.remove("active");
                        } else if (pinstep == 2 || pinstep > 2) {
                            document.querySelector(
                                "#mission_topcolor"
                            ).classList = "state_2";
                            document
                                .querySelector(".msn_info_0")
                                .classList.remove("active");
                            document
                                .querySelector(".msn_info_1")
                                .classList.remove("active");
                            document
                                .querySelector(".msn_info_2")
                                .classList.add("active");
                        }
                    }
                }
            }
            requestAnimationFrame(scrll);
        }
        setTimeout(() => {
            scrll();
        }, startdelay);
    }

    if (qs(".scroll_arrow")) {
        qs(".scroll_arrow").addEventListener("click", () => {
            f -= 0.5 * vh;
        });
    }

    if (qs("#view_home")) {
        // animations

        // function hideidelanim () {
        //     qsa('.bmani').forEach(ani => {
        //         const top = ani.getBoundingClientRect().top
        //         const bottom = ani.getBoundingClientRect().bottom
        //         if(top < vh && bottom > 0) {
        //             ani.style.visibility = 'visible'
        //         } else {
        //             ani.style.visibility = 'hidden'
        //         }
        //     })
        // }
        // setInterval(()=>{ hideidelanim() }, 1000)

        const homeani_l = bodymovin.loadAnimation({
            container: document.getElementById("bmaniheader_l"),
            path: rooturl + "/assets/json/bmaniheader_l.json",
            renderer: "svg",
            loop: false,
            autoplay: false,
        });

        const homeani_r = bodymovin.loadAnimation({
            container: document.getElementById("bmaniheader_r"),
            path: rooturl + "/assets/json/bmaniheader_r.json",
            renderer: "svg",
            loop: false,
            autoplay: false,
        });

        const bmanimission_l = bodymovin.loadAnimation({
            container: document.getElementById("bmanimission_l"),
            path: rooturl + "/assets/json/bmanimission_l.json",
            renderer: "svg",
            loop: true,
            autoplay: true,
        });

        const bmanimission_r = bodymovin.loadAnimation({
            container: document.getElementById("bmanimission_r"),
            path: rooturl + "/assets/json/bmanimission_r.json",
            renderer: "svg",
            loop: true,
            autoplay: true,
        });

        const bmanim1 = bodymovin.loadAnimation({
            container: document.getElementById("bmanim1"),
            path: rooturl + "/assets/json/bmanim1.json",
            renderer: "svg",
            loop: true,
            autoplay: true,
        });

        const bmanim2 = bodymovin.loadAnimation({
            container: document.getElementById("bmanim2"),
            path: rooturl + "/assets/json/bmanim2.json",
            renderer: "svg",
            loop: true,
            autoplay: true,
        });

        function checkanim() {
            if (!tdv) {
                if (window["ss_1"].top > -vh * 0.5) {
                    homeani_l.play();
                    homeani_r.play();
                } else if (window["ss_1"].top < -vh) {
                    homeani_l.goToAndStop(1);
                    homeani_r.goToAndStop(1);
                }
            }

            requestAnimationFrame(checkanim);
        }

        setTimeout(() => {
            requestAnimationFrame(checkanim);
        }, startdelay);

        // tracking code

        setInterval(() => {
            const codefield = qs("#trackingcode").value;
            if (codefield != "") {
                qs(".tracking_btn").classList.add("active");
            } else {
                qs(".tracking_btn").classList.remove("active");
            }
        }, 500);

        qs(".tracking_btn").addEventListener("click", () => {
            alert("Este código no es válido.");
        });
    }

    if (qs("#view_hubber")) {
        // ani header

        const ani_hb_ha = bodymovin.loadAnimation({
            container: document.getElementById("ani_hb_ha"),
            path: rooturl + "/assets/json/ani_hb_ha.json",
            renderer: "svg",
            loop: false,
            autoplay: false,
        });

        const ani_hb_hb = bodymovin.loadAnimation({
            container: document.getElementById("ani_hb_hb"),
            path: rooturl + "/assets/json/ani_hb_hb.json",
            renderer: "svg",
            loop: false,
            autoplay: false,
        });

        function checkanim() {
            if (!tdv) {
                if (window["ss_1"].top > -vh * 0.5) {
                    ani_hb_ha.play();
                    ani_hb_hb.play();
                } else if (window["ss_1"].top < -vh) {
                    ani_hb_ha.goToAndStop(1);
                    ani_hb_hb.goToAndStop(1);
                }
            }

            requestAnimationFrame(checkanim);
        }

        setTimeout(() => {
            requestAnimationFrame(checkanim);
        }, startdelay);

        // clouds

        function getRandom(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        let cloud_count = 0;

        function createcloud() {
            const wr = qs("#hb_yellow");
            const top = getRandom(5, 95);
            const scale = Math.random() * 0.5 + 0.5;
            const type = getRandom(1, 3);
            wr.innerHTML +=
                '<div id="cloud_' +
                cloud_count +
                '" class="cloud type' +
                type +
                '" style="top: ' +
                top +
                "%; transform: scale(" +
                scale +
                ')"></div>';
            cloud_count++;
        }

        function animateclouds() {
            qsa(".cloud").forEach((cloud) => {
                const time = getRandom(10, 25);
                const delay = getRandom(0, 4);
                gsap.fromTo(
                    cloud,
                    { x: "0px" },
                    {
                        x: "-120vw",
                        duration: time,
                        ease: "none",
                        repeat: -1,
                        delay: delay,
                    }
                );
            });
        }

        const createclouds = setInterval(() => {
            if (cloud_count <= 10) {
                createcloud();
            } else {
                clearInterval(createclouds);
                animateclouds();
            }
        }, 30);

        // hubber Y steps

        let hubystate = 1;
        function checkhuby() {
            const el = qs("#hb_yellow");
            const top = el.getBoundingClientRect().top;
            if (top > 0) {
                hubystate = 1;
            } else if (top > -0.6 * vh && top < 0) {
                hubystate = 2;
            } else if (top < -0.6 * vh) {
                hubystate = 3;
            }
            if (hubystate == 1) {
                qs("#wannabe_info").classList = "state1";
            } else if (hubystate == 2) {
                qs("#wannabe_info").classList = "state2";
            } else if (hubystate == 3) {
                qs("#wannabe_info").classList = "state3";
            }
        }
        setInterval(() => {
            checkhuby();
        }, 300);

        // hubber Y pos

        function hubbystate_pos() {
            const fullimg = qs("#hubbfullimg");
            const top = fullimg.getBoundingClientRect().top;
            const pos = vh - top - 3;

            if (top <= vh) {
                qs(".wannabe_wr").style.transform =
                    "translate3d(0,-" + pos / 2 + "px,0)";
            } else {
                qs(".wannabe_wr").style.transform = "none";
            }

            requestAnimationFrame(hubbystate_pos);
        }
        setTimeout(() => {
            requestAnimationFrame(hubbystate_pos);
        }, startdelay);

        // hubb woman

        function checkhubw() {
            const el = qs("#hubbfullimg");
            const top = el.getBoundingClientRect().top;
            const bottom = el.getBoundingClientRect().bottom;

            if (top > 0) {
                qs("#hw_title").classList.add("state1");
                qs("#hw_title").classList.remove("state2");
                qs("#hw_title").classList.remove("state3");
                qs("#hw_title").classList.remove("state4");
            } else if (top < 0 && top > -0.5 * vh) {
                qs("#hw_title").classList.remove("state1");
                qs("#hw_title").classList.add("state2");
                qs("#hw_title").classList.remove("state3");
                qs("#hw_title").classList.remove("state4");
            } else if (top < -0.5 * vh && top > -vh) {
                qs("#hw_title").classList.remove("state1");
                qs("#hw_title").classList.remove("state2");
                qs("#hw_title").classList.add("state3");
                qs("#hw_title").classList.remove("state4");
                qsa(".hubb_detail").forEach(
                    (detail) => (detail.style.opacity = 1)
                );
            } else if (top < -vh) {
                qs("#hw_title").classList.remove("state1");
                qs("#hw_title").classList.remove("state2");
                qs("#hw_title").classList.remove("state3");
                qs("#hw_title").classList.add("state4");
            }

            if (top > vh && bottom > vh) {
                qs(".greystatic_mask").style.height = "0px";
                qs(".greystatic_mask_wr").style.height = vh + "px";
            } else if (top < 0 && bottom < 0) {
                qs(".greystatic_mask").style.height = "0px";
                qs(".greystatic_mask_wr").style.height = vh + "px";
            } else if (top > 0 && bottom > vh) {
                const greystatic_mask_h = vh - top;
                qs(".greystatic_mask").style.height = greystatic_mask_h + "px";
                qs(".greystatic_mask").style.bottom = "0px";
                qs(".greystatic_mask").style.top = "auto";
                qs(".greystatic_mask_wr").style.height = vh + "px";
            } else if (top < 0 && bottom < vh) {
                qs(".greystatic_mask").style.height = vh + "px";
                qs(".greystatic_mask").style.bottom = "auto";
                qs(".greystatic_mask").style.top = "0px";
                qs(".greystatic_mask_wr").style.height =
                    vh - (vh - bottom) + "px";
            }

            requestAnimationFrame(checkhubw);
        }
        setTimeout(() => {
            requestAnimationFrame(checkhubw);
        }, startdelay);

        // hubb sentence static

        function hubsentstatic() {
            const fullimg = qs("#hubb_form");
            const top = fullimg.getBoundingClientRect().top;
            const pos = vh - top - 3;

            if (top <= vh) {
                qs(".greystatic_wr").style.transform =
                    "translate3d(0,-" + pos / 1.5 + "px,0)";
            } else {
                qs(".greystatic_wr").style.transform = "none";
            }

            requestAnimationFrame(hubsentstatic);
        }
        setTimeout(() => {
            requestAnimationFrame(hubsentstatic);
        }, startdelay);
    }

    if (qs("#view_agencia")) {
        // money

        const bmanimoney_1 = bodymovin.loadAnimation({
            container: document.getElementById("bmanimoney_1"),
            path: rooturl + "/assets/json/bmanimoney.json",
            renderer: "svg",
            loop: true,
            autoplay: true,
        });
        const bmanimoney_2 = bodymovin.loadAnimation({
            container: document.getElementById("bmanimoney_2"),
            path: rooturl + "/assets/json/bmanimoney.json",
            renderer: "svg",
            loop: true,
            autoplay: false,
        });
        setTimeout(() => {
            bmanimoney_2.play();
        }, 1000);

        // money translate

        function hubbdetails_pos() {
            const postdiv = qs("#ag_fullimg");
            const top = postdiv.getBoundingClientRect().top;
            const pos = vh - top;

            if (top <= vh) {
                qs("#ag_orange_wr").style.transform =
                    "translate3d(0,-" + pos / 2 + "px,0)";
            } else {
                qs("#ag_orange_wr").style.transform = "none";
            }

            requestAnimationFrame(hubbdetails_pos);
        }
        setTimeout(() => {
            requestAnimationFrame(hubbdetails_pos);
        }, startdelay);

        // fadani

        function fadaniaction() {
            let current = 0;
            let selected = 0;

            qsa(".fadani").forEach((el) => {
                current++;
                const top = el.getBoundingClientRect().top;
                if (top < vh && top > 0) {
                    let opacity = 1 - Math.abs((top / vh) * 2 - 1);
                    el.style.opacity = opacity;
                }
                if (top < 0.4 * vh) {
                    selected = current;
                }
            });

            qsa(".ag_icon").forEach((el) => el.classList.add("inactive"));
            if (qs(".ag_icon_" + selected)) {
                qs(".ag_icon_" + selected).classList.remove("inactive");
            }

            //

            const ref = qs("#ag_icons");
            const wr = qs("#ag_icons_wr");
            const reftop = ref.getBoundingClientRect().top;
            const refbottom = ref.getBoundingClientRect().bottom;
            if (reftop < vh) {
                wr.style.opacity = 1;
            } else {
                wr.style.opacity = 0;
            }
            if (refbottom < 0.5 * vh) {
                qs(".ag_icon_base").style.opacity = 0;
            } else {
                qs(".ag_icon_base").style.opacity = 1;
            }

            requestAnimationFrame(fadaniaction);
        }
        requestAnimationFrame(fadaniaction);
    }

    if (qs("#view_comercio")) {
        function checkgreenactive() {
            let current = 0;
            let lastcurrent = 0;

            qsa(".activate_green").forEach((act) => {
                const top = act.getBoundingClientRect().top;
                if (top < 0.5 * vh) {
                    current = act.getAttribute("green-data");
                }
            });

            if (current != lastcurrent) {
                qsa(".green_desc").forEach((desc) => {
                    const index = desc.getAttribute("index-data");
                    if (index == current) {
                        desc.classList = "desc green_desc";
                    } else if (index < current) {
                        desc.classList = "desc green_desc post";
                    } else if (index > current) {
                        desc.classList = "desc green_desc pre";
                    }
                });
                lastcurrent = current;
            }

            requestAnimationFrame(checkgreenactive);
        }
        setTimeout(() => {
            requestAnimationFrame(checkgreenactive);
        }, startdelay);

        function sunrotation() {
            const sunref = qs("#com_green");
            const top = sunref.getBoundingClientRect().top;
            const height = sunref.clientHeight;

            const passed = top - vh;
            if (passed < 0) {
                const perc = (passed * 100) / height;
                const degrees = (-perc * 200) / 180;
                qs(".sun_wr").style.transform =
                    "translate(-50%,-50%) rotate(" + degrees + "deg)";
            }

            requestAnimationFrame(sunrotation);
        }
        setTimeout(() => {
            requestAnimationFrame(sunrotation);
        }, startdelay);

        const bmani_campaigns = bodymovin.loadAnimation({
            container: document.getElementById("bmani_campaigns"),
            path: rooturl + "/assets/json/bmani_campaigns.json",
            renderer: "svg",
            loop: false,
            autoplay: false,
        });

        function campaigns_position() {
            const wr = qs("#com_campaigns");
            const top = wr.getBoundingClientRect().top;
            const bottom = wr.getBoundingClientRect().bottom;

            if (top > 0) {
                qs("#campaigns_wr").style.transform =
                    "translate3d(0," + top + "px,0)";
            } else if (top < -vh) {
                const currenty = bottom - vh;
                qs("#campaigns_wr").style.transform =
                    "translate3d(0," + currenty + "px,0)";
            } else {
                qs("#campaigns_wr").style.transform = "translate3d(0,0,0)";
            }

            const passed = top;
            if (passed < 0) {
                const perc = (passed * 100) / vh;
                const frame = -parseInt((perc * 160) / 100);
                bmani_campaigns.goToAndStop(frame, true);
            }

            requestAnimationFrame(campaigns_position);
        }
        requestAnimationFrame(campaigns_position);

        function relax_position() {
            const wr = qs("#com_fullimg_relax");
            const top = wr.getBoundingClientRect().top;
            const bottom = wr.getBoundingClientRect().bottom;

            if (top < vh) {
                qs("#com_fullimg_relax_wr").style.opacity = 1;

                if (top <= 0 && top > -0.5 * vh) {
                    const perc = (top * 100) / (0.5 * vh);
                    qs("#relax_slide_1").style.transform =
                        "translate3d(" + perc + "%,0,0)";
                    qs("#relax_slide_2").style.transform = "translate3d(0,0,0)";
                    qs("#relax_slide_3").style.transform = "translate3d(0,0,0)";
                } else if (top < -0.5 * vh && top > -vh) {
                    const newtop = top + 0.5 * vh;
                    const perc = (newtop * 100) / (0.5 * vh);
                    qs("#relax_slide_1").style.transform =
                        "translate3d(-100%,0,0)";
                    qs("#relax_slide_2").style.transform =
                        "translate3d(" + perc + "%,0,0)";
                    qs("#relax_slide_3").style.transform = "translate3d(0,0,0)";
                } else if (top < -vh && top > -1.5 * vh) {
                    const newtop = top + vh;
                    const perc = (newtop * 100) / (0.5 * vh);
                    qs("#relax_slide_1").style.transform =
                        "translate3d(-100%,0,0)";
                    qs("#relax_slide_2").style.transform =
                        "translate3d(-100%,0,0)";
                    qs("#relax_slide_3").style.transform =
                        "translate3d(" + perc + "%,0,0)";
                } else if (top > 0) {
                    qs("#relax_slide_1").style.transform = "translate3d(0,0,0)";
                    qs("#relax_slide_2").style.transform = "translate3d(0,0,0)";
                    qs("#relax_slide_3").style.transform = "translate3d(0,0,0)";
                } else if (top < -1.5 * vh) {
                    qs("#relax_slide_1").style.transform =
                        "translate3d(-100%,0,0)";
                    qs("#relax_slide_2").style.transform =
                        "translate3d(-100%,0,0)";
                    qs("#relax_slide_3").style.transform =
                        "translate3d(-100%,0,0)";
                }
            } else {
                qs("#com_fullimg_relax_wr").style.opacity = 0;
            }

            if (bottom <= vh) {
                const pos = vh - bottom;
                qs("#com_fullimg_relax_wr").style.transform =
                    "translate3d(0,-" + pos / 2 + "px,0)";
            } else {
                qs("#com_fullimg_relax_wr").style.transform = "none";
            }

            requestAnimationFrame(relax_position);
        }
        setTimeout(() => {
            requestAnimationFrame(relax_position);
        }, startdelay);
    }

    // menu

    if (qs("#view_hubber")) {
        qs("#nav_1").classList.add("active");
    }

    qs(".resp_menu_btn").addEventListener("click", () => {
        document.body.classList.toggle("om");
        qs(".nav").classList.remove("register");
        qs(".resp_register_btn").classList.remove("active");
    });

    qs(".resp_register_btn").addEventListener("click", () => {
        qs(".nav").classList.toggle("register");
        document.body.classList.add("om");
        if (qs(".nav").classList.contains("register")) {
            qs(".resp_register_btn").classList.add("active");
        } else {
            qs(".resp_register_btn").classList.remove("active");
        }
    });

    // goto

    function goto(el, tr) {
        if (!tdv) {
            const eltop = -qs(el).getBoundingClientRect().top + t;
            if (tr) {
                f = eltop + (tr * vh) / 100;
            } else {
                f = eltop;
            }
        } else {
            if (tr) {
                const eltop =
                    qs(el).getBoundingClientRect().top +
                    qs("aaa-s-wr").scrollTop -
                    tr;
                qs("aaa-s-wr").scrollTo(0, eltop);
            } else {
                const eltop =
                    qs(el).getBoundingClientRect().top +
                    qs("aaa-s-wr").scrollTop -
                    0.2 * vh;
                qs("aaa-s-wr").scrollTo(0, eltop);
            }
        }
    }

    const params = window.location.href;
    if (params.includes("?form")) {
        goto("#hubb_form");
    } else if (params.includes("?follow")) {
        goto("#details_home");
    } else if (params.includes("?founder")) {
        goto("#founder_words", 15);
    }

    // mail

    if (qs("#sendmail_btn_hubber")) {
        qs("#sendmail_btn_hubber").addEventListener("click", () => {
            const name = qs("#form_name").value;
            const surname = qs("#form_surname").value;
            const email = qs("#form_email").value;
            const phone = qs("#form_phone").value;
            const town = qs("#form_town").value;
            const cp = qs("#form_cp").value;
            const address = qs("#form_address").value;
            const address_extender = qs("#form_address_extender").value;
            const message = qs("#form_message").value;

            if (ValidateEmail(email) == false) {
                qs(".form_error").innerHTML =
                    "Inserte un correo electrónico correcto";
                qs(".form_error").style.display = "block";
                qs(".form_success").style.display = "none";

                return;
            }

            if (
                name &&
                surname &&
                email &&
                phone &&
                address &&
                message &&
                town &&
                cp
            ) {
                if (qs("#form_aceptation").checked) {
                    qs(".form_error").style.display = "none";
                    qs("#sendmail_btn_hubber").style.pointerEvents = "none";

                    /*setTimeout(() => {
                        qs("#sendmail_btn_hubber").style.pointerEvents = "all";
                        qs(".form_success").style.display = "block";

                        setTimeout(() => {
                            qs(".form_success").style.display = "none";
                        }, 3000);

                        qs("#form_name").value = "";
                        qs("#form_surname").value = "";
                        qs("#form_email").value = "";
                        qs("#form_phone").value = "";
                        qs("#form_address").value = "";
                        qs("#form_address_extender").value = "";
                        qs("#form_message").value = "";
                        qs("#form_cp").value = "";
                        qs("#form_town").value = "";
                        qs("#form_town").value = "";
                    }, 1500);*/

                    const xmlhttp = new XMLHttpRequest();

                    xmlhttp.onreadystatechange = function () {
                        qs("#sendmail_btn_hubber").style.pointerEvents = "all";

                        if (xmlhttp.status == 200) {
                            qs(".form_success").style.display = "block";
                            qs(".form_error").style.display = "none";

                            setTimeout(() => {
                                qs(".form_success").style.display = "none";
                            }, 3000);

                            qs("#form_name").value = "";
                            qs("#form_surname").value = "";
                            qs("#form_email").value = "";
                            qs("#form_phone").value = "";
                            qs("#form_address").value = "";
                            qs("#form_address_extender").value = "";
                            qs("#form_message").value = "";
                            qs("#form_cp").value = "";
                            qs("#form_town").value = "";
                            qs("#form_town").value = "";
                        }
                        if (xmlhttp.status == 500) {
                            qs(".form_error").innerHTML =
                                "Ha habido un error, inténtalo de nuevo más tarde";
                            qs(".form_error").style.display = "block";
                            qs(".form_success").style.display = "none";
                            //setTimeout(() => {
                            //    qs(".form_error").style.display = "none";
                            //}, 3000);
                        }
                    };

                    var formData = new FormData();

                    formData.append("name", name);
                    formData.append("lastname", surname);
                    formData.append("email", email);
                    formData.append("phone", phone);
                    formData.append("address", address);
                    formData.append("address_extender", address_extender);
                    formData.append("message", message);
                    formData.append("cp", cp);
                    formData.append("town", town);
                    formData.append(
                        "_token",
                        document.getElementsByName("_token")[0].value
                    );

                    xmlhttp.open("POST", rooturl + "/huber", true);
                    xmlhttp.send(formData);
                } else {
                    qs(".form_error").innerHTML =
                        "Debes aceptar la casilla de privacidad";
                    qs(".form_error").style.display = "block";
                    qs(".form_success").style.display = "none";
                }
            } else {
                qs(".form_error").innerHTML = "Debes rellenar todos los campos";
                qs(".form_error").style.display = "block";
                qs(".form_success").style.display = "none";
                setTimeout(() => {
                    qs(".form_error").style.display = "none";
                }, 3000);
            }
        });
    }

    if (qs("#sendmail_btn_commerce")) {
        qs("#sendmail_btn_commerce").addEventListener("click", () => {
            const name = qs("#form_name").value;
            const surname = qs("#form_surname").value;
            const email = qs("#form_email").value;
            const phone = qs("#form_phone").value;
            const web = qs("#form_web").value;
            const address = qs("#form_address").value;
            const message = qs("#form_message").value;

            if (name && surname && email && phone && address && message) {
                if (qs("#form_aceptation").checked) {
                    qs(".form_error").style.display = "none";
                    qs("#sendmail_btn_commerce").style.pointerEvents = "none";
                    setTimeout(() => {
                        qs("#sendmail_btn_commerce").style.pointerEvents =
                            "all";
                        qs(".form_success").style.display = "block";
                        setTimeout(() => {
                            qs(".form_success").style.display = "none";
                        }, 3000);
                        qs("#form_name").value = "";
                        qs("#form_surname").value = "";
                        qs("#form_email").value = "";
                        qs("#form_phone").value = "";
                        qs("#form_web").value = "";
                        qs("#form_address").value = "";
                        qs("#form_message").value = "";
                    }, 1500);
                    const xmlhttp = new XMLHttpRequest();

                    var formData = new FormData();

                    formData.append("name", name);
                    formData.append("surname", surname);
                    formData.append("email", email);
                    formData.append("phone", phone);
                    formData.append("web", web);
                    formData.append("address", address);
                    formData.append("message", message);
                    formData.append(
                        "_token",
                        document.getElementsByName("_token")[0].value
                    );

                    xmlhttp.open("POST", rooturl + "/ecommerce", true);
                    xmlhttp.send(formData);
                } else {
                    qs(".form_error").innerHTML =
                        "Debes aceptar la casilla de privacidad";
                    qs(".form_error").style.display = "block";
                    qs(".form_success").style.display = "none";
                }
            } else {
                qs(".form_error").innerHTML =
                    "Debes rellenar todos los campos marcados con *";
                qs(".form_error").style.display = "block";
                qs(".form_success").style.display = "none";
                setTimeout(() => {
                    qs(".form_error").style.display = "none";
                }, 3000);
            }
        });
    }
}

if (qs("#view_innerform")) {
    setInterval(() => {
        qsa(".file_attach_wr").forEach((wrapper) => {
            const file = wrapper.querySelector("input").value;
            if (file) {
                wrapper.querySelector(".check").classList.add("active");
            }
        });
    }, 1000);
}

qsa(".big_option").forEach((btn) => {
    btn.addEventListener("click", () => {
        if (btn.classList.contains("left")) {
            qs(".big_option.left").classList = "big_option left selected";
            qs(".big_option.right").classList = "big_option right unselected";
            qs("#optionselected").value = "1";
        } else {
            qs(".big_option.left").classList = "big_option left unselected";
            qs(".big_option.right").classList = "big_option right selected";
            qs("#optionselected").value = "2";
        }
    });
});

window.onload = function () {
    main();
};

function processSelectedFiles(fileInput, boton) {
    //var files = fileInput.files;

    //for (var i = 0; i < files.length; i++) {
    //    console.log(files[i]);
    //}

    removeClass("ok_" + boton, "hide");
    //addClass("adjuntar_" + boton, "hide");
}

function removeClass(id, clase) {
    var element = document.getElementById(id);
    element.classList.remove(clase);
}

function addClass(id, clase) {
    var element = document.getElementById(id);
    element.classList.add(clase);
}

function enviarDocumentacion() {
    //var op1 = document.getElementById("opcion1");
    //var op2 = document.getElementById("opcion2");

    //if (op1.classList.contains("selected") || op1.classList.contains("unselected")) {
    document.getElementById("formuDocu").submit();
    //} else {
    //alert("Debe de seleccionar una opción inicial");
    //}
}
