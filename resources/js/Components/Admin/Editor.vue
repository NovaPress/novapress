<script setup lang="ts">
import Underline from '@tiptap/extension-underline'
import StarterKit from '@tiptap/starter-kit'
import { EditorContent, useEditor } from '@tiptap/vue-3'
import CodeIcon from 'vue-material-design-icons/CodeTags.vue'
import BoldIcon from 'vue-material-design-icons/FormatBold.vue'
import H1Icon from 'vue-material-design-icons/FormatHeader1.vue'
import H2Icon from 'vue-material-design-icons/FormatHeader2.vue'
import H3Icon from 'vue-material-design-icons/FormatHeader3.vue'
import ListDecreaseIcon from 'vue-material-design-icons/FormatIndentDecrease.vue'
import ListIncreaseIcon from 'vue-material-design-icons/FormatIndentIncrease.vue'
import ItalicIcon from 'vue-material-design-icons/FormatItalic.vue'
import ListIcon from 'vue-material-design-icons/FormatListBulleted.vue'
import OrderedListIcon from 'vue-material-design-icons/FormatListNumbered.vue'
import BreakIcon from 'vue-material-design-icons/FormatPageBreak.vue'
import BlockquoteIcon from 'vue-material-design-icons/FormatQuoteClose.vue'
import StrikethroughIcon from 'vue-material-design-icons/FormatStrikethrough.vue'
import UnderlineIcon from 'vue-material-design-icons/FormatUnderline.vue'
import HorizontalRuleIcon from 'vue-material-design-icons/Minus.vue'
import RedoIcon from 'vue-material-design-icons/Redo.vue'
import UndoIcon from 'vue-material-design-icons/Undo.vue'

const props = defineProps({
  modelValue: String,
})

const emit = defineEmits(['update:modelValue'])

const editor = useEditor({
  content: props.modelValue,
  onUpdate: ({ editor }) => {
    emit('update:modelValue', editor.getHTML())
  },
  extensions: [StarterKit, Underline],
  editorProps: {
    attributes: {
      class:
      'rounded-lg border bg-white outline-none focus:border-primary focus-visible:shadow-none text-black dark:bg-boxdark'
      + ' dark:text-white border-stroke p-4 min-h-[24rem] overflow-y-auto prose max-w-none',
    },
  },
})
</script>

<template>
  <div>
    <section
      v-if="editor"
      class="flex items-center flex-wrap gap-x-4 border border-stroke p-4 rounded-lg text-black dark:text-white
        bg-white dark:bg-boxdark mb-8"
    >
      <button
        type="button"
        class="p-1"
        :class="{ 'bg-boxdark dark:bg-white text-white dark:text-black rounded': editor.isActive('bold') }"
        @click="editor.chain().focus().toggleBold().run()"
      >
        <BoldIcon title="Bold" />
      </button>
      <button
        type="button"
        class="p-1"
        :class="{ 'bg-boxdark dark:bg-white text-white dark:text-black rounded': editor.isActive('italic') }"
        @click="editor.chain().focus().toggleItalic().run()"
      >
        <ItalicIcon title="Italic" />
      </button>
      <button
        type="button"
        class="p-1"
        :class="{ 'bg-boxdark dark:bg-white text-white dark:text-black rounded': editor.isActive('underline') }"
        @click="editor.chain().focus().toggleUnderline().run()"
      >
        <UnderlineIcon title="Underline" />
      </button>
      <button
        type="button"
        class="p-1"
        :class="{
          'bg-boxdark dark:bg-white text-white dark:text-black rounded': editor.isActive('heading', { level: 1 }),
        }"
        @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
      >
        <H1Icon title="H1" />
      </button>
      <button
        type="button"
        class="p-1"
        :class="{
          'bg-boxdark dark:bg-white text-white dark:text-black rounded': editor.isActive('heading', { level: 2 }),
        }"
        @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
      >
        <H2Icon title="H2" />
      </button>
      <button
        type="button"
        class="p-1"
        :class="{
          'bg-boxdark dark:bg-white text-white dark:text-black rounded': editor.isActive('heading', { level: 3 }),
        }"
        @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
      >
        <H3Icon title="H3" />
      </button>
      <button
        type="button"
        class="p-1"
        :class="{ 'bg-boxdark dark:bg-white text-white dark:text-black rounded': editor.isActive('bulletList') }"
        @click="editor.chain().focus().toggleBulletList().run()"
      >
        <ListIcon title="Bullet List" />
      </button>
      <button
        type="button"
        class="p-1"
        :class="{ 'bg-boxdark dark:bg-white text-white dark:text-black rounded': editor.isActive('orderedList') }"
        @click="editor.chain().focus().toggleOrderedList().run()"
      >
        <OrderedListIcon title="Ordered List" />
      </button>
      <button
        type="button"
        :class="{ 'bg-boxdark dark:bg-white text-white dark:text-black rounded': editor.isActive('blockquote') }"
        class="p-1"
        @click="editor.chain().focus().toggleBlockquote().run()"
      >
        <BlockquoteIcon title="Blockquote" />
      </button>
      <button
        type="button"
        :class="{ 'bg-boxdark dark:bg-white text-white dark:text-black rounded': editor.isActive('code') }"
        class="p-1"
        @click="editor.chain().focus().toggleCodeBlock().run()"
      >
        <CodeIcon title="Code" />
      </button>
      <button
        type="button"
        class="p-1"
        @click="editor.chain().focus().setHorizontalRule().run()"
      >
        <HorizontalRuleIcon title="Horizontal Rule" />
      </button>
      <button
        type="button"
        class="p-1 disabled:text-gray-400"
        :disabled="!editor.can().chain().focus().undo().run()"
        @click="editor.chain().focus().undo().run()"
      >
        <UndoIcon title="Undo" />
      </button>
      <button
        type="button"
        :disabled="!editor.can().chain().focus().redo().run()"
        class="p-1 disabled:text-gray-400"
        @click="editor.chain().focus().redo().run()"
      >
        <RedoIcon title="Redo" />
      </button>
      <button
        type="button"
        class="p-1"
        @click="editor.chain().focus().setHorizontalRule().run()"
      >
        <BreakIcon title="Break" />
      </button>
      <button
        type="button"
        class="p-1"
        @click="editor.chain().focus().sinkListItem('listItem').run()"
      >
        <ListIncreaseIcon title="ListIncrease" />
      </button>
      <button
        type="button"
        class="p-1"
        @click="editor.chain().focus().liftListItem('listItem').run()"
      >
        <ListDecreaseIcon title="ListDecrease" />
      </button>
      <button
        type="button"
        :class="{ 'bg-gray-200 rounded': editor.isActive('strike') }"
        class="p-1"
        @click="editor.chain().focus().toggleStrike().run()"
      >
        <StrikethroughIcon title="Strikethrough" />
      </button>
    </section>

    <EditorContent :editor="editor" />
  </div>
</template>
