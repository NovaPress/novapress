import antfu from '@antfu/eslint-config'

export default antfu({
  ignores: [
    '**/package.json',
    '**/composer.json',
    '**/tsconfig.json',
  ],
})
