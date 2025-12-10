// postcss.config.cjs - FORMATO CORRETO E COM PLUGIN EXIGIDO
module.exports = {
  plugins: {
    // ALTERADO para o plugin exigido pelo seu ambiente/versão do Tailwind
    '@tailwindcss/postcss': {}, 
    'autoprefixer': {},
  },
}