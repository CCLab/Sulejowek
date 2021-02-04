"use strict";

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var showNav = document.getElementById('menu-button');

if (showNav) {
  showNav.onclick = function (e) {
    e.preventDefault();
    document.body.classList.toggle('menu-visible');
  };
}

function initSwiper(s) {
  var swiper = s.querySelector('.swiper-container');
  var config = swiper.getAttribute('data-swiper-config');
  if (config) config = JSON.parse(config);
  s.swiper = new Swiper(swiper, _objectSpread({
    resistanceRatio: 0.6,
    speed: 700,
    autoHeight: 1,
    slidesPerView: 1,
    navigation: {
      nextEl: s.querySelector('.swiper-button-next'),
      prevEl: s.querySelector('.swiper-button-prev')
    },
    pagination: {
      el: s.querySelector('.swiper-pagination'),
      clickable: 1 //dynamicBullets: true,

    },
    touchEventsTarget: 'container',
    loop: true,
    watchOverflow: true,
    on: {
      init: function init() {
        var slides = this.el.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)');
        if (slides.length == 1) this.el.classList.add('disabled');
      }
    }
  }, config));
}

function conditionalInitSwiper(s) {
  var dont = true;
  if (s.querySelector('.front-test').offsetHeight != 0) dont = false;

  if (!dont) {
    if (!s.swiper) {
      initSwiper(s);
    }
  } else {
    if (s.swiper) {
      s.swiper.destroy(1, 1);
      s.swiper = false;
    }
  }
}

var swipers = document.querySelectorAll('.sul-gallery');
if (swipers) [].forEach.call(swipers, function (s) {
  if (!s.matches('.front-page')) {
    initSwiper(s);
  } else {
    window.addEventListener('resize', function () {
      conditionalInitSwiper(s);
    });
    conditionalInitSwiper(s);
  }
});
/* Mapa */

if (typeof sulmap !== 'undefined' && true) {
  var rem = function rem(size) {
    return size / 16 * rootFontSize;
  };

  var rootFontSize = parseFloat(getComputedStyle(document.documentElement).fontSize);

  window.onresize = function () {
    rootFontSize = parseFloat(getComputedStyle(document.documentElement).fontSize);
  };

  var map = L.map('mapa').setView([52.245232, 21.271219], 15);
  map.scrollWheelZoom.disable(); //https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png
  //http://a.tile.stamen.com/toner-background/{z}/{x}/{y}.png

  L.tileLayer('https://sulejowekposasiedzku.pl/tiles/{z}/{x}/{y}.png', {
    attribution: '<a href="http://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> | Map tiles by <a href="http://stamen.com/">Stamen Design</a>, under <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="http://openstreetmap.org">OpenStreetMap</a>, under <a href="http://www.openstreetmap.org/copyright">ODbL</a>.'
  }).addTo(map);
  var LeafIcon = L.Icon.extend({});
  var primaryIcon = new LeafIcon({
    iconUrl: sulmap.primaryIconSRC
  });
  var secondaryIcon = new LeafIcon({
    iconUrl: sulmap.secondaryIconSRC
  });
  [].forEach.call(sulmap.latlongs, function (a) {
    L.marker([a[0], a[1]], {
      icon: a[3] ? primaryIcon : secondaryIcon
    }).bindPopup(a[2]).addTo(map).on('mouseover', function (ev) {
      this.openPopup();
    });
  });
}
/* player media */


var medias = document.querySelectorAll('.sul-media');

if (medias && document.createElement("template").content) {
  var timeFormat = function timeFormat(t) {
    var date = new Date(0);
    date.setSeconds(t); // specify value for SECONDS here

    if (t > 60 * 60) var timeString = date.toISOString().substr(11, 8);else var timeString = date.toISOString().substr(14, 5);
    return timeString;
  };

  var tml = document.querySelector('#playertml');
  [].forEach.call(medias, function (media) {
    var player = tml.content.cloneNode(true);
    player = player.querySelector('.player');
    media.parentNode.insertBefore(player, media); //player.appendChild( media );

    player.insertBefore(media, player.firstChild); //media.style.display = 'none';

    media.removeAttribute("controls");
    media.addEventListener('loadedmetadata', function (e) {
      player.querySelector('.duration').innerHTML = timeFormat(media.duration.toFixed(0));
    });
    var progressBar = player.querySelector('.progressbar');
    progressBar.addEventListener('click', function (e) {
      var left = e.clientX - this.getBoundingClientRect().left;
      media.currentTime = left / this.offsetWidth * media.duration;
    });
    var playbtn = player.querySelector('.playpause');
    media.addEventListener('timeupdate', function (e) {
      //console.log( e.target.currentTime )
      var currentTime = media.currentTime;
      var duration = media.duration;
      var progress = currentTime / duration * 100;
      player.querySelector('.current').innerHTML = timeFormat(currentTime.toFixed(0));
      player.querySelector('.progress').style.width = progress.toFixed(1) + '%';
    });
    playbtn.addEventListener('click', function (e) {
      if (!media.paused) {
        media.pause();
        player.classList.remove('playing');
        return this.setAttribute('aria-pressed', false);
      } else {
        media.play();
        player.classList.add('playing');
        return this.setAttribute('aria-pressed', true);
      }
    });
  });
}
/* Reveal function */


function revealFunction(e) {
  e.preventDefault();
  var ariaState = this.getAttribute('aria-expanded');
  var target = document.getElementById(this.getAttribute('aria-controls'));

  if (ariaState == 'false') {
    this.setAttribute('aria-expanded', 'true');
    target.classList.remove('hidden');
  } else {
    this.setAttribute('aria-expanded', 'false');
    target.classList.add('hidden');
  }
}

var collapsables = document.querySelectorAll('[data-toggle="collapse"]');

if (collapsables) {
  [].forEach.call(collapsables, function (button) {
    button.addEventListener('click', revealFunction, false);
  });
}