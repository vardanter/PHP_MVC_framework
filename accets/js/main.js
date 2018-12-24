(function() {
	var fileButtons = document.querySelectorAll('.button-file');
	var signupFormElements = document.querySelector('.register-form').elements;

	fileButtons.forEach(function(button) {
		addEventListener(button, 'click', function(e) {
			e.preventDefault();

			var fileInput = document.getElementById(button.getAttribute('ref'));
			fileInput.click();
			addEventListener(fileInput, 'change', function(e) {
				button.innerText = e.target.files[0].name;
			})
		})
	});

	Object.values(signupFormElements).forEach(function(el) {
		addEventListener(el, 'change', handlerChange)
	})
})()

String.prototype.vsprintf = function(params) {
	var counter = 0;

	return this.replace(/%s|%d/g, function() {
		return params[counter++];
	});
};

function addEventListener(obj, ev, callback) {
	if (document.addEventListener) {
		obj.addEventListener(ev, callback);
	} else {
		obj.attachEvent('on' + ev, callback);
	}
}

function handlerChange(e) {
	var error = validate(e.target)
	var elementContainer = e.target.closest('.form__item-group');
	var elementContainerClassNames = elementContainer.className.split(' ');
	var errorBlock = elementContainer.querySelector('.form__item-error');
	var newClassNames;

	if (error.length > 0) {
		newClassNames = [].concat(elementContainerClassNames, ['error']);
		if (!errorBlock) {
			errorBlock = document.createElement('span');
			errorBlock.className = 'form__item-error';
			elementContainer.appendChild(errorBlock);
		}
		errorBlock.innerText = error;
	} else {
		newClassNames = elementContainerClassNames.filter(function(className) {
			return className !== 'error';
		})
		if (errorBlock) {
			errorBlock.remove();
		}
	}
	elementContainer.className = newClassNames.join(' ');
}

var messages = window.translate.messages;

var validateRules = {
	"User[email]": {
		required: {
			value: true,
			message: messages.errors['required'].vsprintf(['"'+messages.site['email']+'"'])
		},
		match: {
			pattern: /^[A-z0-9'.1234z_%+-]+@[A-z0-9.-]+.[A-z]{2,4}$/i,
			message: messages.errors['match'].vsprintf(['"'+messages.site['email']]+'"')
		}
	},
	"User[phone]": {
		required: {
			value: true,
			message: messages.errors['required'].vsprintf(['"'+messages.site['phone']+'"'])
		},
		match: {
			pattern: /[+][0-9]{6,14}/i,
			message: messages.errors['match'].vsprintf(['"'+messages.site['phone']+'"'])
		}
	},
	"Profile[fullname]": {
		required: {
			value: true,
			message: messages.errors['required'].vsprintf(['"'+messages.site['fullname']+'"'])
		},
		match: {
			pattern: /^[A-zА-я ]+$/i,
			message: messages.errors['match'].vsprintf(['"'+messages.site['fullname']+'"'])
		}
	},
	"User[password]": {
		required: {
			value: true,
			message: messages.errors['required'].vsprintf(['"'+messages.site['password']+'"'])
		},
		match: {
			pattern: /^[A-zА-я0-9!#&@]+$/i,
			message: messages.errors['match'].vsprintf(['"'+messages.site['password']+'"'])
		},
		length: {
			min: {
				value: 6,
				message: messages.errors['length'].vsprintf(['"'+messages.site['password']+'"', 6])
			}
		}
	},
	"User[confirm_password]": {
		same: {
			el: document.getElementById('register_form_password'),
			message: messages.errors['same'].vsprintf(['"'+messages.site['confirm_password']+'"', '"'+messages.site['password']+'"'])
		}
	},
	"User[agreement]": {
		required: {
			value: true,
			message: messages.errors['agreement']
		},
	},
	"User[avatar]": {
		mimeType: {
			value: ['image/jpeg', 'image/gif', 'image/png'],
			message: messages.errors['avatar_mime_type']
		}
	}
}

function validate(el) {
	var rules = validateRules[el.name];
	var error = [];

	if (!rules) {
		return;
	}

	Object.keys(rules).forEach(function(rule) {
		switch (rule) {
			case 'required':
				if (rules.required.value && (el.value.length === 0 || el.type === 'checkbox' && !el.checked)) {
					error.push(rules.required.message);
				}
				break;
			case 'match':
				if (!el.value.match(rules.match.pattern)) {
					error.push(rules.match.message);
				}
				break;
			case 'length':
				if (rules.length.min && el.value.length < rules.length.min.value) {
					error.push(rules.length.min.message);
				}
				if (rules.length.max && el.value.length > rules.length.max.value) {
					error.push(rules.length.max.message);
				}
				break;
			case 'same':
				if (el.value !== rules.same.el.value) {
					error.push(rules.same.message);
				}
				break;
			case 'mimeType':
				var trueType = rules.mimeType.value.find(function(type) { return type === el.files[0].type; });

				if (!trueType) {
					error.push(rules.mimeType.message);
				}
		}
	});

	return error[0];
}
