import { defineConfig } from 'vite'

export default defineConfig({
  build: {
    lib: {
      entry: './src/gpt4-content-processor.ts',
      formats: ['cjs'],
      fileName: 'gpt4-content-processor',
    },
    rollupOptions: {
      output: {
        exports: 'named',
      },
    },
    cssPostProcess: async (css) => {
      const postcss = require('postcss')
      const postcssPresetEnv = require('postcss-preset-env')
      const cssnano = require('cssnano')

      const result = await postcss([postcssPresetEnv(), cssnano({ preset: 'default' })]).process(css, { from: undefined })
      return result.css
    },
  },
})
