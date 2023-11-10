<template>
    <div
        class="dropzone-container flex justify-center items-center text-center p-4 row"
        @dragover="dragover"
        @dragleave="dragleave"
        @drop="drop"
    >
        <div class="col-12">
            <input
                type="file"
                multiple
                name="file"
                id="fileInput"
                class="hidden-input"
                @change="onChange"
                ref="file"
                accept=".pdf,.jpg,.jpeg,.png"
            />
            <label for="fileInput" class="file-label">
                <div class="text-sm" v-if="isDragging">
                    Release to drop files here.
                </div>
                <div class="drag-and-drop-content" v-else>
                    <div class="flex justify-center py-4">
                        <img
                            src="/images/admin/base/drop_file_camera.png"
                            alt=""
                        />
                    </div>
                    <div class="text-sm">
                        <div>Drag Your Images To Upload</div>
                        <div>Or <u>Browse</u>.</div>
                    </div>
                </div>
            </label>
        </div>
    </div>
    <div
        class="preview-container p-2 col-12 overflow-y-auto"
        v-if="files.length"
    >
        <div v-for="file in files" :key="file.name">
            <div class="relative p-2" style="width: 250px">
                <div
                    class="absolute top-0 -right-2 bg-gray-500 text-white rounded-full border border-white"
                >
                    <button
                        class="p-1"
                        type="button"
                        @click="remove(files.indexOf(file))"
                        title="Remove file"
                    >
                        <q-icon name="close" size="1.5rem" />
                    </button>
                </div>
                <img class="preview-img" :src="generateURL(file)" />
                <div class="py-2">
                    {{ file.name }} -
                    {{ Math.round(file.size / 1000) + 'kb' }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isDragging: false,
            files: [],
        };
    },
    methods: {
        onChange() {
            const self = this;
            const incomingFiles = Array.from(this.$refs.file.files);
            const fileExist = self.files.some((r) =>
                incomingFiles.some(
                    (file) => file.name === r.name && file.size === r.size
                )
            );
            if (fileExist) {
                self.showMessage = true;
                alert('New upload contains files that already exist');
            } else {
                self.files.push(...incomingFiles);
            }
        },
        dragover(e) {
            e.preventDefault();
            this.isDragging = true;
        },
        dragleave() {
            this.isDragging = false;
        },
        drop(e) {
            e.preventDefault();
            this.$refs.file.files = e.dataTransfer.files;
            this.onChange();
            this.isDragging = false;
        },
        remove(i) {
            this.files.splice(i, 1);
        },
        generateURL(file) {
            const fileSrc = URL.createObjectURL(file);
            setTimeout(() => {
                URL.revokeObjectURL(fileSrc);
            }, 1000);
            return fileSrc;
        },
    },
};
</script>

<style scoped>
.dropzone-container {
    background-image: url('/images/admin/base/drop_file_container.png');
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
    height: 25vh;
    /* height: 40vh; */
}

.hidden-input {
    opacity: 0;
    overflow: hidden;
    position: absolute;
    width: 1px;
    height: 1px;
}

.file-label {
    font-size: 20px;
    display: block;
    cursor: pointer;
}

.preview-container {
    display: flex;
    margin-top: 2rem;
    width: 100%;
}

.preview-img {
    height: 100px;
    width: 100%;
    object-fit: contain;
}

.preview-close-button {
    border: 1px solid;
}

::-webkit-scrollbar {
    width: 0.5rem;
    height: 0.5rem;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 1.25rem;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
