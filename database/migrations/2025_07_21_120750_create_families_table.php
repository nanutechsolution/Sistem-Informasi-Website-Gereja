php artisan make:migration create_families_table<?php

                                                use Illuminate\Database\Migrations\Migration;
                                                use Illuminate\Database\Schema\Blueprint;
                                                use Illuminate\Support\Facades\Schema;

                                                return new class extends Migration
                                                {
                                                    /**
                                                     * Run the migrations.
                                                     */
                                                    public function up(): void
                                                    {
                                                        Schema::create('families', function (Blueprint $table) {
                                                            $table->id();
                                                            $table->foreignId('head_member_id')->constrained('members')->onDelete('cascade'); // ID Kepala Keluarga
                                                            $table->string('family_name')->nullable();
                                                            $table->timestamps();
                                                        });

                                                        // Pivot table untuk anggota keluarga
                                                        Schema::create('family_members', function (Blueprint $table) {
                                                            $table->foreignId('family_id')->constrained('families')->onDelete('cascade');
                                                            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
                                                            $table->string('relationship')->nullable(); // Misal: Suami, Istri, Anak, Orang Tua
                                                            $table->primary(['family_id', 'member_id']); // Compound primary key
                                                        });
                                                    }

                                                    /**
                                                     * Reverse the migrations.
                                                     */
                                                    public function down(): void
                                                    {
                                                        Schema::dropIfExists('family_members');
                                                        Schema::dropIfExists('families');
                                                    }
                                                };
