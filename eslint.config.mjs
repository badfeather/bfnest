import js from '@eslint/js';
import json from '@eslint/json';
import globals from 'globals';

export default [
	{
		files: ['**/*.js', '**/*.mjs'],
		...js.configs.recommended,
		rules: {
			'no-unused-vars': 'warn',
			'no-undef': 'warn',
			'indent': [2, 'tab', {'SwitchCase': 1}],
		},
		languageOptions: {
			globals: {
				...globals.browser,
				'wp': true,
			},
		},
	},
	{
		files: ['**/*.json'],
		...json.configs.recommended,
		ignores: ['package-lock.json'],
		plugins: { json },
		language: 'json/json',
	},
	{
		files: ['**/*.mjs'],
		languageOptions: { sourceType: 'module' }},
];
