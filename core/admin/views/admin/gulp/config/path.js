import * as nodePath from 'path';
const rootFolder = nodePath.basename(nodePath.resolve());


const buildFolder = `./dist`;
const srcFolder = `./src`;


export const path = {
	build: {
		js: `${buildFolder}/js/`,
		images: `${buildFolder}/img/`,
		html: `${buildFolder}/`,
		css: `${buildFolder}/css/`,
        files: `${buildFolder}/files/`,
		fonts: `${buildFolder}/fonts/`,
    },
	src: {
		js: `${srcFolder}/js/*.js`,
		images: `${srcFolder}/img/**/*.{jpg,jpeg,png,gif,webp}`,
		svg: `${srcFolder}/img/**/*.svg`,
		html: `${srcFolder}/*.html`,
		scss: `${srcFolder}/scss/*.scss`,
        files: `${srcFolder}/files/**/*.*`,
		svgicons: `${srcFolder}/svgicons/*.svg`,
    },
	watch: {
		js: `${srcFolder}/js/**/*.js`,
		scss: `${srcFolder}/scss/**/*.scss`,
		html: `${srcFolder}/**/*.html`,
		images: `${srcFolder}/img/**/*.{jpg,jpeg,png,gif,webp,svg,ico}`,
		files: `${srcFolder}/files/**/*.*`,
		svgSprive: `${srcFolder}/svgicons/**/*.svg`
	},
	clean: buildFolder,
	buildFolder: buildFolder,
	srcFolder: srcFolder,
	rootFolder: rootFolder,
	ftp: ``,
}