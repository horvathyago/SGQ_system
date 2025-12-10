/** @type {import('tailwindcss').Config} */
export default {
  // A seção 'content' é CRÍTICA. Ela diz ao Tailwind onde procurar as classes que você usou.
  content: [
    // Varre o arquivo index.html na raiz (bom para classes globais como bg-gray-50)
    "./index.html",
    // Varre TODOS os arquivos .js, .ts, .jsx e .tsx dentro da pasta src/ e subpastas.
    "./src/**/*.{js,ts,jsx,tsx}", 
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}