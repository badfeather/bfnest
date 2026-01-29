const fs = require('fs-extra');
const pjson = require('./package.json');

// https://github.com/marella/material-design-icons/tree/main/svg#readme
// view icons: https://marella.github.io/material-design-icons/demo/svg/
let material = [
	'add.svg',
	'arrow_back_ios.svg',
	'arrow_drop_down.svg',
	'arrow_drop_up.svg',
	'arrow_forward_ios.svg',
	'chevron_left.svg',
	'chevron_right.svg',
	'close.svg',
	'expand_less.svg',
	'expand_more.svg',
	'file_download.svg',
	'insert_drive_file.svg',
	'launch.svg',
	'mail.svg',
	'menu.svg',
	'arrow_drop_down.svg',
	'arrow_drop_up.svg'
];

// https://github.com/simple-icons/simple-icons
// view icons https://simpleicons.org/
let brands = [
	'bluesky.svg',
	'digg.svg',
	'facebook.svg',
	'github.svg',
	'instagram.svg',
	// 'linkedin.svg', unavailable currently, but saved in 'img/svg-icons'
	'mastodon.svg',
	'pinterest.svg',
	'reddit.svg',
	'threads.svg',
	'tumblr.svg',
	'vimeo.svg',
	'youtube.svg',
	'x.svg',
];

function copyFiles(srcDir, destDir, files) {
	if (!Array.isArray(files) || !files.length) return;
	for (let file of files) {
		try {
			fs.copySync(srcDir + file, destDir + file);
			console.log(file + ' copied to ' + destDir);
		} catch (err) {
			console.error(err);
		}
	}
}

// last directory can be filled, outlined, round, sharp, or two-tone
copyFiles('node_modules/@material-design-icons/svg/sharp/', 'img/svg-icons/', material);
copyFiles('node_modules/simple-icons/icons/', 'img/svg-icons/', brands);

// merge two arrays of icons and alphabetize
// let icons = material.concat(brands);
let icons = fs.readdirSync('img/svg-icons');
// const icons = [];
// dirFiles.forEach(file => {
// 	icons.push(file.slice(0, -3));
// });
console.log(icons);
icons.sort();
let styles = `
.icon {
	display: inline-block;
	vertical-align: middle;
	mask-image: url(../img/icon-sprite.svg?v=${pjson.version});
	mask-size: 100% auto;
	width: 1em;
	height: 1em;
	mask-repeat: no-repeat;
	background-color: currentColor;
}
[class*="icon"] {
	@extend .icon;
}`;

let i = 0;

for (let icon of icons) {
	let y = i === 0 ? '0' : `-${i}em`;
	let key = icon.split("/").pop().replace('.svg', '');
	styles += `
.icon--${key} {
	mask-position: 0 ${y};
}`;
	i++;
}

// write styles to sass file
let writeStream = fs.createWriteStream("src/sass/_icons.scss");
writeStream.write(styles);
writeStream.end();

