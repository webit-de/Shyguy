class InsertSoftHyphenHandler {
  constructor() {
    this.btnInsertShy = document.querySelector("a[href=\"#insertSoftHyphen\"]");
    this.btnInsertSuper = document.querySelector("a[href=\"#insertSuperscript\"]");
    this.btnInsertSub = document.querySelector("a[href=\"#insertSubscript\"]");
    this.btnInsertQuote = document.querySelector("a[href=\"#insertQuotationMarks\"]");
    this.allowedCharacters = {
      'superscript' : { '\u2070': /0/g, '\u00B9': /1/g, '\u00B2': /2/g, '\u00B3': /3/g, '\u2074': /4/g, '\u2075': /5/g, '\u2076': /6/g, '\u2077': /7/g, '\u2078': /8/g, '\u2079': /9/g, '\u207A': /\+/g, '\u207B': /-/g, '\u207C': /=/g, '\u207D': /\(/g, '\u207E': /\)/g, '\u207F': /n/g },
      'subscript' : { '\u2080': /0/g, '\u2081': /1/g, '\u2082': /2/g, '\u2083': /3/g, '\u2084': /4/g, '\u2085': /5/g, '\u2086': /6/g, '\u2087': /7/g, '\u2088': /8/g, '\u2089': /9/g, '\u208A': /\+/g, '\u208B': /-/g, '\u208C': /=/g, '\u208D': /\(/g, '\u208E': /\)/g, '\u2090': /a/g, '\u2091': /e/g, '\u2092': /o/g, '\u2093': /x/g, '\u2095': /h/g, '\u2096': /k/g, '\u2097': /l/g, '\u2098': /m/g, '\u2099': /n/g, '\u209A': /p/g, '\u209B': /s/g, '\u209C': /t/g }
    };

    this.init();
  }

  /**
   * @return {InsertSoftHyphenHandler}
   */
  init() {
    if (this.btnInsertShy) {
      this.btnInsertShy.addEventListener("mousedown", this.handleInsertShyClick.bind(this));
    }
    if (this.btnInsertSuper) {
      this.btnInsertSuper.addEventListener("mousedown", this.handleInsertSuperClick.bind(this));
    }
    if (this.btnInsertSub) {
      this.btnInsertSub.addEventListener("mousedown", this.handleInsertSubClick.bind(this));
    }
    if (this.btnInsertQuote) {
      this.btnInsertQuote.addEventListener("mousedown", this.handleInsertQuoteClick.bind(this));
    }

    this.replaceDomGlyphes();

    return this;
  }

  /**
   * Handle insert soft-hyphen button click
   * https://ckeditor.com/docs/ckeditor5/latest/examples/how-tos.html#how-to-get-the-editor-instance-object-from-the-dom-element
   */
  handleInsertShyClick(event) {
    event.preventDefault();

    let activeElement = document.activeElement;
    const domEditableElement = document.querySelector(".ck-editor__editable_inline");

    if (domEditableElement !== null && domEditableElement.ckeditorInstance.editing.view.document.isFocused === true) {
      const editorInstance = domEditableElement.ckeditorInstance;
      editorInstance.execute("insertText", { text: "­" });
      editorInstance.editing.view.focus();
    } else if (activeElement.tagName.toLowerCase() === "input" || activeElement.tagName.toLowerCase() === "textarea") {
      let activeElementRange = this.getCaretPosition(activeElement);

      activeElement.value = this.replaceRange(activeElement.value, activeElementRange["start"], activeElementRange["end"], "↵");
      this.dispatchChangeEvents(activeElement);
    }
  }

  handleInsertSuperClick(event) {
    this.insertSpecialChar(event, 'superscript');
  }
  handleInsertSubClick(event) {
    this.insertSpecialChar(event, 'subscript');
  }

  insertSpecialChar(event, type) {
    event.preventDefault();

    let activeElement = document.activeElement;
    const domEditableElement = document.querySelector(".ck-editor__editable_inline");

    if (activeElement.tagName.toLowerCase() === "input" || activeElement.tagName.toLowerCase() === "textarea") {
      let activeElementRange = this.getCaretPosition(activeElement);
      activeElement.value = this.replaceAllowedCharacters(activeElement.value, activeElementRange["start"], activeElementRange["end"], this.allowedCharacters[type]);
      this.dispatchChangeEvents(activeElement);
    }
  }

  handleInsertQuoteClick(event) {
    event.preventDefault();

    let activeElement = document.activeElement;
    const domEditableElement = document.querySelector(".ck-editor__editable_inline");

    if (activeElement.tagName.toLowerCase() === "input" || activeElement.tagName.toLowerCase() === "textarea") {
      let activeElementRange = this.getCaretPosition(activeElement);
      activeElement.value = this.wrapAroundRange(activeElement.value, activeElementRange["start"], activeElementRange["end"], "„", "“");
      this.dispatchChangeEvents(activeElement);
    }
  }

  /**
   * Replace Existing ↵ with &shy; glyph in input fields and text areas
   */
  replaceDomGlyphes() {
    const elements = document.querySelectorAll("input, .form-wizards-element textarea[id^=\"formengine-textarea-\"]");
    elements.forEach(function(element) {
      element.value = element.value.replace(/(\&shy;|\­)/gi, "↵");
    });
  }

  /**
   * Get caret position
   */
  getCaretPosition(ctrl) {
    return {
      "start": ctrl.selectionStart ?? 0,
      "end": ctrl.selectionEnd ?? 0
    };
  }

  /**
   * @return {InsertSoftHyphenHandler}
   */
  replaceRange(s, start, end, substitute) {
    return s.substring(0, start) + substitute + s.substring(end);
  }

  wrapAroundRange(s,start,end,wrapFront, wrapBack = wrapFront) {
    return s.substring(0, start) + wrapFront + s.substring(start,end) + wrapBack + s.substring(end);
  }
  replaceAllowedCharacters(s,start,end,allowedCharactersList) {
    let selection = s.substring(start,end);
    for (let allowedChar in allowedCharactersList) {
      selection = selection.replace(allowedCharactersList[allowedChar], allowedChar);
    }
    return this.replaceRange(s, start, end, selection);
  }

  dispatchChangeEvents(ctrl) {
    ctrl.dispatchEvent(new Event("change", { "bubbles": true }));
    ctrl.dispatchEvent(new Event("keyup", { "bubbles": true }));
  }
}

export default new InsertSoftHyphenHandler();
