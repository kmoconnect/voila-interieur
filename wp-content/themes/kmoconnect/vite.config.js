import { defineConfig } from "vite";
import liveReload from "vite-plugin-live-reload";
import autoprefixer from "autoprefixer";
import terser from "rollup-plugin-terser";

const { resolve } = require("path");

export default defineConfig({
  plugins: [liveReload(__dirname + "/**/*.php")],
  base:
    process.env.NODE_ENV === "development"
      ? "/wp-content/themes/kmoconnect/"
      : "./",
  build: {
    outDir: resolve(__dirname, "./assets/dist"),
    emptyOutDir: true,
    assetsDir: "",
    manifest: true,
    target: "es2018",
    minify: "terser",
    terserOptions: {
      mangle: {
        reserved: ["wc"],
      },
    },
    // our entry
    rollupOptions: {
      input: {
        main: resolve(__dirname + "/assets/src/js/main.js"),
      },
      output: {
        entryFileNames: `[name].js`,
        assetFileNames: "[name].[ext]",
      },
    },
    write: true,
    cssMinify: process.env.NODE_ENV !== "development",
  },
  server: {
    cors: { origin: "*" },
    strictPort: true,
    host: true,
    https: false,
    hmr: {
      host: "localhost",
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        relativeUrls: true,
      },
    },
    postcss: {
      plugins: [autoprefixer({})],
    },
  },
});
