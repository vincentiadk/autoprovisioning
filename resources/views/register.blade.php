<div class="container">
    <form method="POST" action="{{ url('register') }}">
        @csrf
        @include('partials.message')
        <div class="row">
            <img src="{{ asset('assets/static/images/logo_horizontal.svg') }}">
        </div>
        <div class="row">
            <h4>Account</h4>
            <div class="input-group input-group-icon">
                <input type="text" placeholder="Full Name" name="nama" value="{{ old('nama') }}" required minlength="6">
                <div class="input-icon"><i class="fa fa-user"></i></div>
            </div>
            <div class="input-group input-group-icon">
                <input type="email" placeholder="Email Adress" name="email" value="{{ old('email') }}" required>
                <div class="input-icon"><i class="fa fa-envelope"></i></div>
            </div>
            <div class="input-group input-group-icon">
                <input type="password" placeholder="Password" name="password" required minlength="6">
                <div class="input-icon"><i class="fa fa-key"></i></div>
            </div>
            <div class="input-group input-group-icon">
                <input type="password" placeholder="Password Confirmation" name="password_confirmation" required
                    minlength="6">
                <div class="input-icon"><i class="fa fa-key"></i></div>
            </div>
            <div class="input-group input-group-icon">
                <input type="number" placeholder="Phone Number" name="phone_number" value="{{ old('phone_number') }}"
                    maxlength="12" minlength="9" required>
                <div class="input-icon" style="margin:0px; color:black;"> + 62 </div>
            </div>
            <div class="input-group input-group-icon">
                <input type="number" placeholder="NIK" name="nik" value="{{ old('nik') }}" required maxlength="8"
                    minlength="6">
                <div class="input-icon"> <i class="fa fa-address-card"></i> </div>
            </div>
            <div class="input-group">
                <select name="regional" required>
                    <option>Pilih Regional</option>
                    <option value="1" @if(old('regional')==1) selected @endif>Regional 1</option>
                    <option value="2" @if(old('regional')==2) selected @endif>Regional 2</option>
                    <option value="3" @if(old('regional')==3) selected @endif>Regional 3</option>
                    <option value="4" @if(old('regional')==4) selected @endif>Regional 4</option>
                    <option value="5" @if(old('regional')==5) selected @endif>Regional 5</option>
                    <option value="6" @if(old('regional')==6) selected @endif>Regional 6</option>
                    <option value="7" @if(old('regional')==7) selected @endif>Regional 7</option>
                </select>
            </div>
        </div>
        <div class="row">
            <h4>Terms and Conditions</h4>
            <div class="input-group">
                <input type="checkbox" id="terms" required>
                <label for="terms">I accept the <a href="#" data-toggle="modal" data-target="#modal-toc"
                        style="color:red">terms and conditions</a> for signing up to this service, and hereby
                    confirm I have read the privacy policy.</label>
            </div>
        </div>
        <div class="row">
            <button class="btn btn-primary" style="width:100%">Register</button>
			<div class="sso">
                <a href="/login" class="page" style="text-align:center">or Login</a>
            </div>
        </div>
    </form>
    <div class="modal fade" id="modal-toc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle" style="color:#000">GENERAL TERM OF USE
                        PROVISIONING
                        SERVICE TELKOMSEL</h3>
                </div>
                <div class="modal-body">

                    {{-- MDOAL TOC --}}
                    <div style="color:#000">
                        <ol>
                            <li>
                                <strong>PENGERTIAN</strong><br>
                                <strong>TELKOM</strong> adalah Badan Usaha Milik Negara yang dalam hal ini sebagai
                                pemilik
                                dari layanan email Telkom.<br><br>

                                <strong>Pengguna</strong> adalah setiap pihak yang membuka, menggunakan, atau mengakses
                                situs web ini.<br><br>

                                <strong>Undang-undang Hak Cipta</strong> adalah Undang-undang Nomor 28 tahun 2014
                                tentang
                                Hak Cipta.<br><br>

                                <strong>Situs</strong> adalah situs web yang beralamat di
                                <strong>opt.telkom.co.id/provisioning</strong><br><br>

                                <strong>Situs Pihak Ketiga</strong> adalah situs yang dioperasikan oleh pihak/perusahaan
                                lain<br><br>
                            </li>
                            <li>
                                <strong>KETENTUAN PENGGUNAAN</strong><br>
                                Ketentuan Penggunaan berlaku untuk Situs
                                (<strong>opt.telkom.co.id/provisioning</strong>)
                                yang dioperasikan oleh TELKOM dan setiap informasi yang terdapat dan/atau disalurkan
                                melalui
                                server TELKOM. Pengguna yang mengakses Situs ini dianggap telah membaca dan menyetujui
                                ketentuan pengunaan Situs ini.<br><br>

                                TELKOM dapat sewaktu-waktu mengubah, menambah dan/atau menghapus bagian manapun dari
                                Ketentuan Penggunaan tanpa pemberitahuan terlebih dahulu.<br><br>

                                Pengguna disarankan membaca dengan seksama dan secara berkala mengunjungi halaman ini
                                untuk
                                mendapatkan informasi terkini untuk mengetahui segala perubahan dalam ketentuan
                                Penggunaan.<br><br>
                            </li>
                            <li>
                                <strong>PENGGUNAAN UMUM SITUS</strong><br>
                                Pengguna menyatakan bahwa pengguna adalah benar pegawai Telkom dan atau Mitra yang
                                berkerja
                                di bawah naungan Perusahaan Telkom dan dalam pengawasan Pegawai yang bertanggung jawab
                                terhadap Mitra terebut.<br><br>

                                Segala hal terkait pengaksesan dan penggunaan Situs ini dilakukan atas tanggung jawab
                                Pengguna, sehingga semua risiko untuk penggunaan Situs ini ditanggung oleh
                                Pengguna.<br><br>

                                TELKOM berhak meminta Pengguna untuk memberikan informasi yang akurat pada saat
                                pendaftaran
                                akun agar dapat beberapa fitur atau layanan sesuai yang tertera dalam Kebijakan
                                Privasi.<br><br>

                                TELKOM berhak menutup dan/atau memberhentikan akses terhadap Situs dan/atau memblokir
                                akun
                                Pengguna dan/atau membatasi pengunaan layanan oleh Pengguna sewaktu-waktu tanpa
                                diperlukannya pemberitahuan apabila:<br><br>
                                <ol type="a">
                                    <li>Pengguna telah melakukan pelanggaran terhadap larangan-larangan sebagaimana yang
                                        tercantum dalam butir 5 Pemakaian Yang Dilarang;</li>
                                    <li>Pengguna memberikan keterangan palsu, tidak benar, atau tidak lengkap terhadap
                                        data
                                        dan informasi yang dibutuhkan termasuk identitas Pengguna.</li>
                                    <li>Adanya permintaan dari aparat penegak hukum guna kepentingan penyidikan sesuai
                                        dengan peraturan dan ketentuan hukum yang berlaku di Negara Republik Indonesia
                                    </li>
                                </ol><br>
                                Penggunaan Situs hanya untuk penggunaan kedinasan dan tidak bersifat pribadi.<br><br>
                            </li>
                            <li>
                                <strong>PEMBATASAN TANGGUNG JAWAB TELKOM</strong><br>
                                TELKOM tidak bertanggung jawab atas:<br><br>
                                <ol type="a">
                                    <li>Segala kerusakan atau kerugian Pengguna yang dihasilkan dari informasi (termasuk
                                        data dan/atau sejenisnya) yang disediakan melalui Situs ini.</li>
                                    <li>Segala kerusakan atau kerugian Pengguna apapun yang dihasilkan dari penggunaan
                                        informasi yang diperoleh dari Situs Pihak Ketiga yang terhubung dengan Situs
                                        ini.
                                    </li>
                                </ol><br>
                            </li>
                            <li>
                                <strong>PENGGUNAAN SITUS YANG DILARANG</strong><br>
                                Pengguna dilarang untuk:<br>
                                <ol type="a">
                                    <li>Menggunakan Situs atau isinya untuk tujuan apapun yang melanggar hukum atau
                                        dilarang
                                        oleh Ketentuan Penggunaan ini;</li>
                                    <li>Mengambil, mengunduh, memungut atau menyimpan informasi pribadi tentang pengguna
                                        lain;</li>
                                    <li>Menggunakan program-program seperti robot, spider, scraper atau cara otomatis
                                        atau
                                        manual lainnya untuk mengakses, memantau atau menyalin konten dan/atau informasi
                                        apapun di Situs;</li>
                                    <li>Mengirim virus, spam, program atau teknik lainnya pada Situs;</li>
                                    <li>Mendekompilasi, membongkar, atau merekayasa balik setiap perangkat lunak atau
                                        konten
                                        yang digunakan di bagian manapun dari Situs atau jaringan TELKOM;</li>
                                    <li>Melakukan tindakan apapun untuk menghindar dari langkah-langkah yang dapat
                                        TELKOM
                                        gunakan untuk mencegah, mengganggu, atau membatasi akses ke Situs atau jaringan
                                        TELKOM;</li>
                                    <li>Membuat terjadinya Overload atau crash terhadap Situs, server atau jaringan
                                        TELKOM;
                                        dan</li>
                                    <li>Melakukan segala tindakan lainnya yang dapat menghambat dan/atau mempengaruhi
                                        TELKOM
                                        untuk melakukan pengoperasian Situs, layanan, dan perangkat.</li>
                                </ol><br>
                            </li>
                            <li>
                                <strong>HAK KEKAYAAN INTELEKTUAL</strong><br>
                                Segala merk dagang, merk layanan, logo, gambar, ikon, produk dan nama jasa, desain dan
                                nama
                                perusahaan serta yang terdapat dalam Situs, baik yang telah terdaftar maupun belum tidak
                                terdaftar, merupakan merk dagang milik TELKOM, anak perusahaan atau pihak ketiga lainnya
                                yang tidak boleh disalin, ditiru, atau digunakan, baik secara keseluruhan atau sebagian
                                tanpa persetujuan tertulis dari TELKOM atau pemilik terkait sesuai dengan Undang-Undang
                                Hak
                                Cipta.<br><br>
                            </li>
                            <li>
                                <strong>KEAMANAN</strong><br>
                                Pengguna mungkin akan memerlukan sebuah nama pengguna, nama akun, atau kata sandi untuk
                                mengakses beberapa bagian dari Situs. Penggunaan fitur-fitur ini merupakan tanda
                                persetujuan
                                dari Pengguna untuk menjaga kerahasiaan dan keamanan informasi ini. <br><br>

                                Pengguna bertanggung jawab atas semua aktivitas yang terjadi dengan nama pengguna, akun
                                atau
                                kata sandi. Jika kerahasiaan nama pengguna, akun atau kata sandi Pengguna digunakan oleh
                                pihak lain, maka Pengguna dengan segera harus memberi tahu TELKOM melalui
                                <strong>abuse@telkom.co.id</strong> dan dengan Subyek email berupa “Aduan
                                Privasi”.<br><br>

                                TELKOM tidak bertanggung jawab atas kerugian yang mungkin dialami oleh Pengguna akibat
                                pihak
                                lain menggunakan akun atau kata sandi Pengguna.<br><br>

                                TELKOM berhak untuk menghentikan akun atau menangguhkan akun, serta mengubah nama
                                pengguna
                                atau kata sandi, dan meminta informasi tambahan dari Pengguna serta melakukan tindakan
                                wajar, perlu, dan penting lainnya demi melindungi keamanan Situs dan akun
                                Pelanggan.<br><br>

                                Pengguna dilarang mempublikasikan celah keamanan yang ditemukan dalam Situs atau layanan
                                TELKOM lainnya kepada khalayak umum tanpa seizin TEKOM.<br><br>

                                Pengguna dilarang memanfaatkan celah keamanan yang ditemukan dalam Situs atau Layanan
                                TELKOM
                                lainnya untuk kepentingan pribadi atau kelompok tertentu.<br><br>
                            </li>
                            <li>
                                <strong>TANGGAPAN (FEEDBACK)</strong><br>
                                Segala tanggapan, saran, dan atau penemuan yang anda berikan terkait Situs ini dan
                                layanan
                                lainnya dianggap sebagai non confidential. TELKOM berhak atas pengunaan informasi ini
                                secara
                                bebas tanpa batas. Pelanggan dilarang untuk menyalahgunakan penemuan dari Situs yang
                                dapat
                                mempengaruhi TELKOM dalam melakukan pengoperasian Situs dan layanan lainnya.<br><br>
                            </li>
                            <li>
                                <strong>PERATURAN YANG BERLAKU</strong><br>
                                Ketentuan Penggunaan ini diatur oleh dan akan diberlakukan berdasarkan peraturan
                                perundang-undangan yang berlaku di Republik Indonesia.<br><br>
                            </li>
                            <li>
                                <strong>KEBIJAKAN PRIVASI</strong><br>
                                Kebijakan privasi aplikasi berikut ini menjelaskan bagaimana Kami mengumpulkan,
                                menggunakan,
                                memindahkan, mengungkapkan dan melindungi informasi pribadi Anda yang dapat
                                diidentifikasi
                                yang diperoleh melalui Situs Kami (sebagaimana didefinisikan di bawah). Mohon Anda
                                membaca
                                Kebijakan Privasi ini dengan seksama untuk memastikan bahwa Anda memahami bagaimana
                                ketentuan Kebijakan Privasi ini Kami berlakukan.<br><br>

                                Kebijakan Privasi ini disertakan sebagai bagian dari Ketentuan Penggunaan Kami.
                                Kebijakan
                                Privasi ini mencakup hal-hal sebagai berikut:
                                <ol>
                                    <li>Definisi</li>
                                    <li>Informasi yang Kami kumpulkan</li>
                                    <li>Keamanan</li>
                                    <li>Perubahan atas Kebijakan Privasi ini</li>
                                    <li>Lain-lain</li>
                                    <li>Pengakuan dan persetujuan</li>
                                    <li>Cara untuk menghubungi Kami</li>
                                </ol><br>
                                Penggunaan Anda atas Situs dan Layanan Kami tunduk pada Ketentuan Penggunaan dan
                                Kebijakan
                                Privasi ini dan mengindikasikan persetujuan Anda terhadap Ketentuan Penggunaan dan
                                Kebijakan
                                Privasi tersebut.<br><br>
                                <ol>
                                    <li>Definisi<br>
                                        <ul>
                                            <li>“Kami” berarti Perusahaan Perseroan (Persero) PT. Telekomunikasi
                                                Indonesia,
                                                Tbk., suatu perusahaan yang didirikan berdasarkan hukum Negara Republik
                                                Indonesia.</li>
                                            <li>“Layanan” berarti seluruh layanan yang terdapat pada situs
                                                <strong>opt.telkom.co.id/provisioning</strong>
                                            </li>
                                            <li>“Informasi Pribadi” berarti informasi mengenai Anda yang secara pribadi
                                                dapat diidentifikasi yang dikumpulkan melalui Aplikasi, seperti nama,
                                                alamat, tanggal lahir, nomor telepon, lokasi bekerja, alamat surat
                                                elektronik (e-mail) Anda dan/atau sejenisnya, dan informasi lain yang
                                                berkaitan dengan Human Capital.</li>
                                            <li>“Situs” berarti Situs Web Kami di umail.telkom.co.id</li>
                                        </ul><br>
                                    </li>

                                    <li>Informasi yang Kami Kumpulkan<br>
                                        <ul>
                                            <li>Kami mengumpulkan Informasi Pribadi tertentu dari berupa Nama, NIK,
                                                Jabatan,
                                                Divisi dan Lokasi kerja untuk memberikan layanan yang sesuai dengan
                                                kebutuhan anda.</li>
                                            <li>Ketika Anda mengunjungi Situs Web Kami, administrator Situs Web Kami
                                                akan
                                                memproses data teknis seperti alamat IP Anda, browser internet yang Anda
                                                gunakan, dan durasi setiap kunjungan/sesi yang memungkinkan Kami untuk
                                                mengirimkan fungsi-fungsi Situs Web.</li>
                                        </ul>
                                    </li>
                                    <li>Keamanan<br>
                                        Kami akan menjaga kerahasiaan setiap data yang diberikan oleh Anda. Namun, Kami
                                        tidak menjamin keamanan database Kami dan Kami juga tidak menjamin bahwa data
                                        yang
                                        Anda berikan tidak akan tertahan/terganggu ketika sedang dikirimkan kepada Kami.
                                        Anda tidak diperbolehkan mengungkapkan sandi Anda kepada siapapun. Bagaimanapun
                                        efektifnya suatu teknologi, tidak ada sistem keamanan yang tidak dapat
                                        ditembus.<br><br>
                                    </li>

                                    <li>Perubahan atas Kebijakan Privasi ini<br>
                                        Kami dapat mengubah Kebijakan Privasi ini untuk mencerminkan perubahan dalam
                                        kegiatan Kami. Kami menghimbau Anda untuk meninjau halaman ini secara berkala
                                        untuk
                                        mengetahui informasi terbaru tentang bagaimana ketentuan Kebijakan Privasi ini
                                        Kami
                                        berlakukan.<br><br>
                                    </li>
                                    <li>Lain-lain<br>
                                        Hukum yang mengatur dan yurisdiksi. Kebijakan Privasi ini diatur oleh dan untuk
                                        ditafsirkan dalam hukum Negara Republik Indonesia. Setiap dan seluruh sengketa
                                        yang
                                        timbul dari kebijakan privasi ini akan diatur oleh yurisdiksi eksklusif dari
                                        Pengadilan Negeri Jakarta Selatan.<br><br>
                                    </li>
                                    <li>Pengakuan dan persetujuan<br>
                                        <ul>
                                            <li>Dengan menggunakan Aplikasi, Anda mengakui bahwa Anda telah membaca dan
                                                memahami Kebijakan Privasi ini dan Ketentuan Penggunaan dan setuju dan
                                                sepakat terhadap penggunaan, praktek, pemrosesan dan pengalihan
                                                informasi
                                                pribadi Anda oleh Kami sebagaimana dinyatakan di dalam Kebijakan Privasi
                                                ini.</li>
                                            <li>Anda juga menyatakan bahwa Anda memiliki hak untuk membagikan seluruh
                                                informasi yang telah Anda berikan kepada Kami dan untuk memberikan hak
                                                kepada Kami untuk menggunakan dan membagikan informasi tersebut kepada
                                                Penyedia Layanan.</li>
                                        </ul><br>
                                    </li>

                                    <li>Cara untuk menghubungi Kami<br>
                                        Jika Anda memiliki pertanyaan lebih lanjut tentang privasi dan keamanan
                                        informasi
                                        Anda dan ingin memperbarui atau menghapus data Anda maka silakan hubungi Kami
                                        di:<br><br>
                                        Helpdesk IT : (Telegram) 0811 2244 472, (Phone) 1500472, (Email)
                                        it-care@telkom.co.id
                                    </li>
                                </ol>
                            </li>
                        </ol>
                        <p></p>

                        <footer class="footer">
                            <p>© {{date('Y')}} PT. Telekomunikasi Indoneisa, Tbk. ( versi 1.0 )</p>
                        </footer>

                    </div> <!-- /container -->
                    {{-- END OF MODAL TOC --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>