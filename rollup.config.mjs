import terser from '@rollup/plugin-terser';
import { nodeResolve } from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
// import { fileURLToPath } from 'url';
// const __filename = fileURLToPath(import.meta.url);
// global['__filename'] = __filename;

let files = ['theme.js', 'block-filters.js'];
export default files.map(function (file) {
	let name = file.replace('.js', '');
	return {
		input: `src/js/${file}`,
		output: [
			{
				file: `js/${name}.js`,
				format: 'iife',
				sourcemap: true
			},
			{
				file: `js/${name}.min.js`,
				format: 'iife',
				plugins: [terser()],
				sourcemap: true
			},
		],
		plugins: [nodeResolve()]
	};
});
