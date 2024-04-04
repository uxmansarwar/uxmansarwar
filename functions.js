/**
 * 
 * @param {*} _url 
 * @param {*} _text 
 * @returns 
 * line breaks use '%0D%0A%0D%0A%0D%0A'
 */
function socialMediaSharer(_url = SITE_URL + '/' + page_slug, _text = '') {
    return {
        facebook: `https://www.facebook.com/sharer/sharer.php?u=` + encodeURIComponent(_url),
        twitter: `https://twitter.com/intent/tweet?url=${encodeURIComponent(_url)}&text= ` + encodeURIComponent(_text),
        linkedin: `https://www.linkedin.com/shareArticle?mini=true&url=` + encodeURIComponent(_url),
        pinterest: `https://pinterest.com/pin/create/button/?url=` + encodeURIComponent(_url),
        skype: `https://web.skype.com/share?url=` + encodeURIComponent(_url),
        yahoo: `https://compose.mail.yahoo.com/?body=` + encodeURIComponent(_url) + '&subject=' + encodeURIComponent(_text),
        reddit: `https://reddit.com/submit?url=` + encodeURIComponent(_url) + '%0D' + encodeURIComponent(_text) + '&title=' + encodeURIComponent(_text.slice(0, 100)),
        whatsapp: `https://web.whatsapp.com/send?text=` + encodeURIComponent(_url) + '%0A' + encodeURIComponent(_text),
        gmail: `https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=&body=` + encodeURIComponent(_url) + '%0D' + encodeURIComponent(_text) + '&su=' + encodeURIComponent(_text.slice(0, 100)),
        mix: `https://mix.com/share?url=` + encodeURIComponent(_url),
        ok: `https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=` + encodeURIComponent(_url),
        blogger: `https://www.blogger.com/blog-this.g?b=` + encodeURIComponent(_url) + '&t=' + encodeURIComponent(_text.slice(0, 100)) + '&v=3' + '&b=' + encodeURIComponent(_text.slice(0, 100)),


    };
}


/**
 * @string text_ any string without sanitization, it will be sanitized and count characters with spaces 
 * @returns number of characters in the text
 * @returnType @int
 */
const charCounter = text_ => text_.replace(/\s+/g, ' ').length;
/**
 * @string text_ any string without sanitization, it will be sanitized and count characters with spaces 
 * @returns number of spaces in the text
 * @returnType @int
 */
const spaceCounter = text_ => text_.split(' ').length;
/**
 * @string text_ any string without sanitization, it will be sanitized and counted
 * @returns @int number of words
 * @returnType @int
 */
const wordCounter = text_ => text_.replace(/\s+/g, ' ').split(' ').length;
/**
 * @int text_ any string without sanitization, it will be sanitized and count sentences
 * @int max_sen_len maximum number of characters in a sentence
 * @returns number of sentences in the text
 * @returnType @int
 */
const sentenceCounter = (text_, max_sen_len = 7) => Array.from(text_.replace(/\s+/g, ' ').split('.')).map(sentence => sentence.trim().length < max_sen_len ? null : sentence).filter(x => x).length;


/**
 * @string _word any string without sanitization, it will be sanitized and count syllables
 * @returns @int number of syllables in given word
 * @returnType @int
 */
const syllableCounter = _word => _word.toLowerCase().match(/[^aeiouy]*[aeiouy]+/g)?.length ?? 0;


/**
 * @formula from google results Coleman Liau Index formula: 5.89 x (characters/words) - 0.3 x (sentences/words) – 15.8.
 * @IPLocation Coleman Liau Index formula: 5.125 x (characters/words) - 0.3 x (sentences/words) - 15.8
 * @int total_sen total number of sentences 
 * @int total_words total number of words 
 * @int total_chars total number of characters
 * @returns coleman_liau_index
 * @returnType @int
 */
const colemanLiau = (total_sen, total_words, total_chars) => (5.125 * (total_chars / total_words)) - 0.3 * (total_sen / total_words) - 15.8;

/**
 * 
 * @param callback callAbleFunction 
 */
function onDOMReady(callAbleFunction) {
    document.readyState == 'loading' ? document.addEventListener('DOMContentLoaded', callAbleFunction) : callAbleFunction();
}

function elemSelector(x, temp_dom = document.body, working_area_id = 'working_area', i = x.indexOf('#' + working_area_id), res = []) {
    i > -1 ? (res[working_area_id] = temp_dom = temp_dom.querySelector('#' + working_area_id)) && x.splice(i, 1) : '';
    x.forEach(e => res[e.startsWith('.') || e.startsWith('#') ? e.substr(1) : e] = e.startsWith('#') ? temp_dom.querySelector(e) : temp_dom.querySelectorAll(e));
    return res;
}

const isEmail = eml => {
    let t = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return t.test(eml);
}

const randomNumber = (max = 100, min = 0) => Math.floor((Math.random() * max) + min);

const isEmpty = prm => prm == '' || prm.length == 0 ? true : false;

/**
 * @array _ array only
 * @returns unique array
 * @returnType @array
 */
const arrayUnique = _ => _.filter((v, i, a) => a.indexOf(v) === i);
