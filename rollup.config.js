import { terser } from 'rollup-plugin-terser';
import { nodeResolve } from '@rollup/plugin-node-resolve';

let files = ['theme.js', 'blockfilters.js'];
export default files.map(function (file) {
	return {
		input: `src/js/${file}`,
		output: {
			file: `js/${file}`,
			format: 'iife',
			name: file.replace('.js', ''),
			plugins: [terser()],
			sourcemap: true
		},
		plugins: [nodeResolve()]
	};
});

