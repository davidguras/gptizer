import { defineConfig } from 'vite';
import { resolve } from 'path';
import postcss from 'rollup-plugin-postcss';
import cssnano from 'cssnano';
import image from '@rollup/plugin-image';
import copy from 'rollup-plugin-copy';
import url from '@rollup/plugin-url';
import { babel } from '@rollup/plugin-babel';

const JS_DIR = resolve(__dirname, 'assets/src/js');
const IMG_DIR = resolve(__dirname, 'assets/src/img');
const BUILD_DIR = resolve(__dirname, 'assets/build');

export default defineConfig(({ mode }) => {
	const isProduction = 'production' === mode;

	return {
		build: {
			outDir: BUILD_DIR,
			assetsDir: '',
			sourcemap: true,
			rollupOptions: {
				input: {
					editor: resolve(JS_DIR, 'editor.js'),
				},
				output: {
					entryFileNames: 'js/[name].js',
				},
				plugins: [
					babel({
						exclude: 'node_modules/**',
						presets: [
							[
								'@babel/preset-env',
								{
									targets: '> 0.25%, not dead',
								},
							],
						],
						babelHelpers: 'bundled',
					}),
					postcss({
						extract: true,
						minimize: isProduction,
						sourceMap: true,
						plugins: [cssnano()],
						modules: {
							generateScopedName:
								'[name]__[local]___[hash:base64:5]',
						},
					}),
					image(),
					url({
						include: [
							'**/*.woff',
							'**/*.woff2',
							'**/*.ttf',
							'**/*.eot',
							'**/*.svg',
						],
						exclude: [IMG_DIR, 'node_modules/**'],
						publicPath: isProduction ? '../' : '../../',
					}),
					copy({
						targets: [
							// { src: LIB_DIR, dest: BUILD_DIR + '/library' },
						],
					}),
					isProduction,
				],
			},
		},
	};
});
