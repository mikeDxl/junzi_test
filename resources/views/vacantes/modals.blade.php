<!--  Perfil de puesto -->
<div class="custom-modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
    <div class="bg-white rounded-xl shadow-2xl border-0 transition-all duration-300 ease-out transform"
         style="max-width: 1200px; width: 95%; max-height: 95vh; overflow: hidden;">
        <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50">
            <!-- Header mejorado -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-tie text-blue-600"></i>
                    </div>
                    <h5 class="text-xl font-semibold text-gray-800 m-0">Perfil de Puesto</h5>
                </div>
                <button type="button"
                        onclick="closeCustomModal('customModal')"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-red-50 hover:text-red-600 transition-all duration-200 transform hover:scale-110 border-0 outline-none">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Content área mejorada -->
            <div class="text-center">
                <div class="border-2 border-dashed border-gray-200 rounded-lg p-8 bg-gradient-to-br from-gray-50 to-blue-50 hover:border-blue-300 transition-colors duration-300"
                     style="height: 500px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-file-alt text-2xl text-blue-600"></i>
                    </div>
                    <p class="text-gray-600 mb-2 font-medium">Aquí se mostrará el perfil de puesto</p>
                    <p class="text-gray-500 text-sm">Modal personalizado con estilos mejorados</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alta de candidato -->
<div class="custom-modal" id="customAltaCandidato">
    <div class="bg-white rounded-xl shadow-2xl border-0 transition-all duration-300 ease-out transform max-w-2xl w-full mx-4 max-h-[95vh] overflow-hidden">
        <div class="p-6">
            <!-- Header mejorado -->
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <h5 class="text-xl font-semibold text-gray-800 m-0">Agregar Nuevo Candidato</h5>
                </div>
                <button type="button"
                        onclick="closeCustomModal('customAltaCandidato')"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-red-50 hover:text-red-600 transition-all duration-200 transform hover:scale-110 border-0 outline-none"
                        title="Cerrar">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Form container con scroll personalizado -->
            <div class="max-h-[70vh] overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 #f1f5f9;">
                <form id="candidatoForm" onsubmit="handleFormSubmit(event)" class="space-y-5">

                    <!-- Nombre -->
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-2 transition-colors group-focus-within:text-blue-600">
                            <i class="fas fa-user text-xs mr-2 text-gray-400"></i>Nombre *
                        </label>
                        <input type="text"
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 outline-none placeholder-gray-400"
                               name="nombre"
                               required
                               placeholder="Ingresa el nombre completo">
                    </div>

                    <!-- Apellidos en una fila -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Apellido Paterno -->
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2 transition-colors group-focus-within:text-blue-600">
                                <i class="fas fa-user-tag text-xs mr-2 text-gray-400"></i>Apellido Paterno *
                            </label>
                            <input type="text"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 outline-none placeholder-gray-400"
                                   name="apellido_paterno"
                                   required
                                   placeholder="Apellido paterno">
                        </div>

                        <!-- Apellido Materno -->
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2 transition-colors group-focus-within:text-blue-600">
                                <i class="fas fa-user-tag text-xs mr-2 text-gray-400"></i>Apellido Materno
                            </label>
                            <input type="text"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 outline-none placeholder-gray-400"
                                   name="apellido_materno"
                                   placeholder="Apellido materno">
                        </div>
                    </div>

                    <!-- Curriculum con área de drop -->
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-2 transition-colors group-focus-within:text-blue-600">
                            <i class="fas fa-file-upload text-xs mr-2 text-gray-400"></i>Curriculum Vitae *
                        </label>
                        <div class="relative">
                            <input type="file"
                                   class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 hover:bg-blue-50 hover:border-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                   name="curriculum"
                                   id="customCurriculum"
                                   required
                                   accept=".pdf,.doc,.docx">
                        </div>
                        <div class="mt-2 flex items-center space-x-2">
                            <i class="fas fa-info-circle text-xs text-blue-500"></i>
                            {{-- <small class="text-blue-600 font-medium">Archivos permitidos: PDF, DOC, DOCX (Máximo 2MB)</small> --}}
                        </div>
                    </div>

                    <!-- Comentarios -->
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-2 transition-colors group-focus-within:text-blue-600">
                            <i class="fas fa-comment-alt text-xs mr-2 text-gray-400"></i>Comentarios
                        </label>
                        <textarea class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 outline-none placeholder-gray-400 resize-none"
                                  name="comentarios"
                                  rows="4"
                                  placeholder="Comentarios adicionales sobre el candidato..."></textarea>
                    </div>

                    <!-- Fuente de prospección -->
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-2 transition-colors group-focus-within:text-blue-600">
                            <i class="fas fa-search text-xs mr-2 text-gray-400"></i>Fuente de Prospección *
                        </label>
                        <div class="relative">
                            <select class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 outline-none appearance-none cursor-pointer"
                                    name="fuente" required>
                                <option value="" class="text-gray-400">Selecciona una opción</option>
                                <option value="Redes sociales">🌐 Redes sociales</option>
                                <option value="Plataformas Web">💻 Plataformas Web</option>
                                <option value="Referencias">👥 Referencias</option>
                                <option value="Periódico">📰 Periódico</option>
                                <option value="Directo en planta">🏢 Directo en planta</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                        <button type="button"
                                class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-1"
                                onclick="closeCustomModal('customAltaCandidato')">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-medium transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i>Guardar Candidato
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Animaciones mejoradas para los modales */
.custom-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6));
    backdrop-filter: blur(8px);
    z-index: 1055;
    padding: 20px;
    box-sizing: border-box;
}

.custom-modal.show {
    display: flex !important;
    align-items: center;
    justify-content: center;
}

.custom-modal.show > div {
    animation: modalSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: scale(0.8) translateY(-50px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Efectos hover mejorados */
.group:hover label {
    color: #3b82f6;
}

/* Scroll personalizado para WebKit */
.custom-modal ::-webkit-scrollbar {
    width: 6px;
}

.custom-modal ::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.custom-modal ::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.custom-modal ::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Efectos de enfoque mejorados */
.group input:focus + .absolute i,
.group select:focus + .absolute i {
    color: #3b82f6;
}

/* Efectos de archivo personalizado */
input[type="file"]::-webkit-file-upload-button {
    transition: all 0.2s ease;
}

input[type="file"]:hover::-webkit-file-upload-button {
    background-color: #dbeafe;
}
</style>
