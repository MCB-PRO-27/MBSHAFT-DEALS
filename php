Enter file contents hereSkip to content 


   You have no unread notifications 

  
This repository  







 Show command bar help  
Explore


Gist


Blog


Help


MCB-PRO-27 MCB-PRO-27 


  Create new...




 Account settings (You have no verified emails)
! 

 Sign out















You don't have any verified emails. We recommend verifying at least one email. 

Email verification helps our support team help you in case you have any email issues or lose your password. 





  
8   Watch   























  

 Star  23  

Fork  12 

public  gndev  / shortcodes-ultimate Octocat-spinner-32 
  





  Octocat-spinner-32 
Code

   Octocat-spinner-32 
Issues

   Octocat-spinner-32 
Pull Requests


  Octocat-spinner-32 
Pulse

  Octocat-spinner-32 
Graphs

  Octocat-spinner-32 
Network


















 
 
 

 branch: master  




















   
shortcodes-ultimate / inc / core / data.php  
 
Vladimir Anokhin gndev a month ago 4.6.1  

1 contributor
 


Vladimir Anokhin




 file  2506 lines (2497 sloc)  89.058 kb 


 Open Open this file in GitHub for Windows EditClicking this button will automatically fork this project so you can edit the file Raw Blame History 
 Delete Fork this project and delete file  


1

2

3

4

5

6

7

8

9

10

11

12

13

14

15

16

17

18

19

20

21

22

23

24

25

26

27

28

29

30

31

32

33

34

35

36

37

38

39

40

41

42

43

44

45

46

47

48

49

50

51

52

53

54

55

56

57

58

59

60

61

62

63

64

65

66

67

68

69

70

71

72

73

74

75

76

77

78

79

80

81

82

83

84

85

86

87

88

89

90

91

92

93

94

95

96

97

98

99

100

101

102

103

104

105

106

107

108

109

110

111

112

113

114

115

116

117

118

119

120

121

122

123

124

125

126

127

128

129

130

131

132

133

134

135

136

137

138

139

140

141

142

143

144

145

146

147

148

149

150

151

152

153

154

155

156

157

158

159

160

161

162

163

164

165

166

167

168

169

170

171

172

173

174

175

176

177

178

179

180

181

182

183

184

185

186

187

188

189

190

191

192

193

194

195

196

197

198

199

200

201

202

203

204

205

206

207

208

209

210

211

212

213

214

215

216

217

218

219

220

221

222

223

224

225

226

227

228

229

230

231

232

233

234

235

236

237

238

239

240

241

242

243

244

245

246

247

248

249

250

251

252

253

254

255

256

257

258

259

260

261

262

263

264

265

266

267

268

269

270

271

272

273

274

275

276

277

278

279

280

281

282

283

284

285

286

287

288

289

290

291

292

293

294

295

296

297

298

299

300

301

302

303

304

305

306

307

308

309

310

311

312

313

314

315

316

317

318

319

320

321

322

323

324

325

326

327

328

329

330

331

332

333

334

335

336

337

338

339

340

341

342

343

344

345

346

347

348

349

350

351

352

353

354

355

356

357

358

359

360

361

362

363

364

365

366

367

368

369

370

371

372

373

374

375

376

377

378

379

380

381

382

383

384

385

386

387

388

389

390

391

392

393

394

395

396

397

398

399

400

401

402

403

404

405

406

407

408

409

410

411

412

413

414

415

416

417

418

419

420

421

422

423

424

425

426

427

428

429

430

431

432

433

434

435

436

437

438

439

440

441

442

443

444

445

446

447

448

449

450

451

452

453

454

455

456

457

458

459

460

461

462

463

464

465

466

467

468

469

470

471

472

473

474

475

476

477

478

479

480

481

482

483

484

485

486

487

488

489

490

491

492

493

494

495

496

497

498

499

500

501

502

503

504

505

506

507

508

509

510

511

512

513

514

515

516

517

518

519

520

521

522

523

524

525

526

527

528

529

530

531

532

533

534

535

536

537

538

539

540

541

542

543

544

545

546

547

548

549

550

551

552

553

554

555

556

557

558

559

560

561

562

563

564

565

566

567

568

569

570

571

572

573

574

575

576

577

578

579

580

581

582

583

584

585

586

587

588

589

590

591

592

593

594

595

596

597

598

599

600

601

602

603

604

605

606

607

608

609

610

611

612

613

614

615

616

617

618

619

620

621

622

623

624

625

626

627

628

629

630

631

632

633

634

635

636

637

638

639

640

641

642

643

644

645

646

647

648

649

650

651

652

653

654

655

656

657

658

659

660

661

662

663

664

665

666

667

668

669

670

671

672

673

674

675

676

677

678

679

680

681

682

683

684

685

686

687

688

689

690

691

692

693

694

695

696

697

698

699

700

701

702

703

704

705

706

707

708

709

710

711

712

713

714

715

716

717

718

719

720

721

722

723

724

725

726

727

728

729

730

731

732

733

734

735

736

737

738

739

740

741

742

743

744

745

746

747

748

749

750

751

752

753

754

755

756

757

758

759

760

761

762

763

764

765

766

767

768

769

770

771

772

773

774

775

776

777

778

779

780

781

782

783

784

785

786

787

788

789

790

791

792

793

794

795

796

797

798

799

800

801

802

803

804

805

806

807

808

809

810

811

812

813

814

815

816

817

818

819

820

821

822

823

824

825

826

827

828

829

830

831

832

833

834

835

836

837

838

839

840

841

842

843

844

845

846

847

848

849

850

851

852

853

854

855

856

857

858

859

860

861

862

863

864

865

866

867

868

869

870

871

872

873

874

875

876

877

878

879

880

881

882

883

884

885

886

887

888

889

890

891

892

893

894

895

896

897

898

899

900

901

902

903

904

905

906

907

908

909

910

911

912

913

914

915

916

917

918

919

920

921

922

923

924

925

926

927

928

929

930

931

932

933

934

935

936

937

938

939

940

941

942

943

944

945

946

947

948

949

950

951

952

953

954

955

956

957

958

959

960

961

962

963

964

965

966

967

968

969

970

971

972

973

974

975

976

977

978

979

980

981

982

983

984

985

986

987

988

989

990

991

992

993

994

995

996

997

998

999

1000

1001

1002

1003

1004

1005

1006

1007

1008

1009

1010

1011

1012

1013

1014

1015

1016

1017

1018

1019

1020

1021

1022

1023

1024

1025

1026

1027

1028

1029

1030

1031

1032

1033

1034

1035

1036

1037

1038

1039

1040

1041

1042

1043

1044

1045

1046

1047

1048

1049

1050

1051

1052

1053

1054

1055

1056

1057

1058

1059

1060

1061

1062

1063

1064

1065

1066

1067

1068

1069

1070

1071

1072

1073

1074

1075

1076

1077

1078

1079

1080

1081

1082

1083

1084

1085

1086

1087

1088

1089

1090

1091

1092

1093

1094

1095

1096

1097

1098

1099

1100

1101

1102

1103

1104

1105

1106

1107

1108

1109

1110

1111

1112

1113

1114

1115

1116

1117

1118

1119

1120

1121

1122

1123

1124

1125

1126

1127

1128

1129

1130

1131

1132

1133

1134

1135

1136

1137

1138

1139

1140

1141

1142

1143

1144

1145

1146

1147

1148

1149

1150

1151

1152

1153

1154

1155

1156

1157

1158

1159

1160

1161

1162

1163

1164

1165

1166

1167

1168

1169

1170

1171

1172

1173

1174

1175

1176

1177

1178

1179

1180

1181

1182

1183

1184

1185

1186

1187

1188

1189

1190

1191

1192

1193

1194

1195

1196

1197

1198

1199

1200

1201

1202

1203

1204

1205

1206

1207

1208

1209

1210

1211

1212

1213

1214

1215

1216

1217

1218

1219

1220

1221

1222

1223

1224

1225

1226

1227

1228

1229

1230

1231

1232

1233

1234

1235

1236

1237

1238

1239

1240

1241

1242

1243

1244

1245

1246

1247

1248

1249

1250

1251

1252

1253

1254

1255

1256

1257

1258

1259

1260

1261

1262

1263

1264

1265

1266

1267

1268

1269

1270

1271

1272

1273

1274

1275

1276

1277

1278

1279

1280

1281

1282

1283

1284

1285

1286

1287

1288

1289

1290

1291

1292

1293

1294

1295

1296

1297

1298

1299

1300

1301

1302

1303

1304

1305

1306

1307

1308

1309

1310

1311

1312

1313

1314

1315

1316

1317

1318

1319

1320

1321

1322

1323

1324

1325

1326

1327

1328

1329

1330

1331

1332

1333

1334

1335

1336

1337

1338

1339

1340

1341

1342

1343

1344

1345

1346

1347

1348

1349

1350

1351

1352

1353

1354

1355

1356

1357

1358

1359

1360

1361

1362

1363

1364

1365

1366

1367

1368

1369

1370

1371

1372

1373

1374

1375

1376

1377

1378

1379

1380

1381

1382

1383

1384

1385

1386

1387

1388

1389

1390

1391

1392

1393

1394

1395

1396

1397

1398

1399

1400

1401

1402

1403

1404

1405

1406

1407

1408

1409

1410

1411

1412

1413

1414

1415

1416

1417

1418

1419

1420

1421

1422

1423

1424

1425

1426

1427

1428

1429

1430

1431

1432

1433

1434

1435

1436

1437

1438

1439

1440

1441

1442

1443

1444

1445

1446

1447

1448

1449

1450

1451

1452

1453

1454

1455

1456

1457

1458

1459

1460

1461

1462

1463

1464

1465

1466

1467

1468

1469

1470

1471

1472

1473

1474

1475

1476

1477

1478

1479

1480

1481

1482

1483

1484

1485

1486

1487

1488

1489

1490

1491

1492

1493

1494

1495

1496

1497

1498

1499

1500

1501

1502

1503

1504

1505

1506

1507

1508

1509

1510

1511

1512

1513

1514

1515

1516

1517

1518

1519

1520

1521

1522

1523

1524

1525

1526

1527

1528

1529

1530

1531

1532

1533

1534

1535

1536

1537

1538

1539

1540

1541

1542

1543

1544

1545

1546

1547

1548

1549

1550

1551

1552

1553

1554

1555

1556

1557

1558

1559

1560

1561

1562

1563

1564

1565

1566

1567

1568

1569

1570

1571

1572

1573

1574

1575

1576

1577

1578

1579

1580

1581

1582

1583

1584

1585

1586

1587

1588

1589

1590

1591

1592

1593

1594

1595

1596

1597

1598

1599

1600

1601

1602

1603

1604

1605

1606

1607

1608

1609

1610

1611

1612

1613

1614

1615

1616

1617

1618

1619

1620

1621

1622

1623

1624

1625

1626

1627

1628

1629

1630

1631

1632

1633

1634

1635

1636

1637

1638

1639

1640

1641

1642

1643

1644

1645

1646

1647

1648

1649

1650

1651

1652

1653

1654

1655

1656

1657

1658

1659

1660

1661

1662

1663

1664

1665

1666

1667

1668

1669

1670

1671

1672

1673

1674

1675

1676

1677

1678

1679

1680

1681

1682

1683

1684

1685

1686

1687

1688

1689

1690

1691

1692

1693

1694

1695

1696

1697

1698

1699

1700

1701

1702

1703

1704

1705

1706

1707

1708

1709

1710

1711

1712

1713

1714

1715

1716

1717

1718

1719

1720

1721

1722

1723

1724

1725

1726

1727

1728

1729

1730

1731

1732

1733

1734

1735

1736

1737

1738

1739

1740

1741

1742

1743

1744

1745

1746

1747

1748

1749

1750

1751

1752

1753

1754

1755

1756

1757

1758

1759

1760

1761

1762

1763

1764

1765

1766

1767

1768

1769

1770

1771

1772

1773

1774

1775

1776

1777

1778

1779

1780

1781

1782

1783

1784

1785

1786

1787

1788

1789

1790

1791

1792

1793

1794

1795

1796

1797

1798

1799

1800

1801

1802

1803

1804

1805

1806

1807

1808

1809

1810

1811

1812

1813

1814

1815

1816

1817

1818

1819

1820

1821

1822

1823

1824

1825

1826

1827

1828

1829

1830

1831

1832

1833

1834

1835

1836

1837

1838

1839

1840

1841

1842

1843

1844

1845

1846

1847

1848

1849

1850

1851

1852

1853

1854

1855

1856

1857

1858

1859

1860

1861

1862

1863

1864

1865

1866

1867

1868

1869

1870

1871

1872

1873

1874

1875

1876

1877

1878

1879

1880

1881

1882

1883

1884

1885

1886

1887

1888

1889

1890

1891

1892

1893

1894

1895

1896

1897

1898

1899

1900

1901

1902

1903

1904

1905

1906

1907

1908

1909

1910

1911

1912

1913

1914

1915

1916

1917

1918

1919

1920

1921

1922

1923

1924

1925

1926

1927

1928

1929

1930

1931

1932

1933

1934

1935

1936

1937

1938

1939

1940

1941

1942

1943

1944

1945

1946

1947

1948

1949

1950

1951

1952

1953

1954

1955

1956

1957

1958

1959

1960

1961

1962

1963

1964

1965

1966

1967

1968

1969

1970

1971

1972

1973

1974

1975

1976

1977

1978

1979

1980

1981

1982

1983

1984

1985

1986

1987

1988

1989

1990

1991

1992

1993

1994

1995

1996

1997

1998

1999

2000

2001

2002

2003

2004

2005

2006

2007

2008

2009

2010

2011

2012

2013

2014

2015

2016

2017

2018

2019

2020

2021

2022

2023

2024

2025

2026

2027

2028

2029

2030

2031

2032

2033

2034

2035

2036

2037

2038

2039

2040

2041

2042

2043

2044

2045

2046

2047

2048

2049

2050

2051

2052

2053

2054

2055

2056

2057

2058

2059

2060

2061

2062

2063

2064

2065

2066

2067

2068

2069

2070

2071

2072

2073

2074

2075

2076

2077

2078

2079

2080

2081

2082

2083

2084

2085

2086

2087

2088

2089

2090

2091

2092

2093

2094

2095

2096

2097

2098

2099

2100

2101

2102

2103

2104

2105

2106

2107

2108

2109

2110

2111

2112

2113

2114

2115

2116

2117

2118

2119

2120

2121

2122

2123

2124

2125

2126

2127

2128

2129

2130

2131

2132

2133

2134

2135

2136

2137

2138

2139

2140

2141

2142

2143

2144

2145

2146

2147

2148

2149

2150

2151

2152

2153

2154

2155

2156

2157

2158

2159

2160

2161

2162

2163

2164

2165

2166

2167

2168

2169

2170

2171

2172

2173

2174

2175

2176

2177

2178

2179

2180

2181

2182

2183

2184

2185

2186

2187

2188

2189

2190

2191

2192

2193

2194

2195

2196

2197

2198

2199

2200

2201

2202

2203

2204

2205

2206

2207

2208

2209

2210

2211

2212

2213

2214

2215

2216

2217

2218

2219

2220

2221

2222

2223

2224

2225

2226

2227

2228

2229

2230

2231

2232

2233

2234

2235

2236

2237

2238

2239

2240

2241

2242

2243

2244

2245

2246

2247

2248

2249

2250

2251

2252

2253

2254

2255

2256

2257

2258

2259

2260

2261

2262

2263

2264

2265

2266

2267

2268

2269

2270

2271

2272

2273

2274

2275

2276

2277

2278

2279

2280

2281

2282

2283

2284

2285

2286

2287

2288

2289

2290

2291

2292

2293

2294

2295

2296

2297

2298

2299

2300

2301

2302

2303

2304

2305

2306

2307

2308

2309

2310

2311

2312

2313

2314

2315

2316

2317

2318

2319

2320

2321

2322

2323

2324

2325

2326

2327

2328

2329

2330

2331

2332

2333

2334

2335

2336

2337

2338

2339

2340

2341

2342

2343

2344

2345

2346

2347

2348

2349

2350

2351

2352

2353

2354

2355

2356

2357

2358

2359

2360

2361

2362

2363

2364

2365

2366

2367

2368

2369

2370

2371

2372

2373

2374

2375

2376

2377

2378

2379

2380

2381

2382

2383

2384

2385

2386

2387

2388

2389

2390

2391

2392

2393

2394

2395

2396

2397

2398

2399

2400

2401

2402

2403

2404

2405

2406

2407

2408

2409

2410

2411

2412

2413

2414

2415

2416

2417

2418

2419

2420

2421

2422

2423

2424

2425

2426

2427

2428

2429

2430

2431

2432

2433

2434

2435

2436

2437

2438

2439

2440

2441

2442

2443

2444

2445

2446

2447

2448

2449

2450

2451

2452

2453

2454

2455

2456

2457

2458

2459

2460

2461

2462

2463

2464

2465

2466

2467

2468

2469

2470

2471

2472

2473

2474

2475

2476

2477

2478

2479

2480

2481

2482

2483

2484

2485

2486

2487

2488

2489

2490

2491

2492

2493

2494

2495

2496

2497

2498

2499

2500

2501

2502

2503

2504

2505
 
<?php
/**
 * Class for managing plugin data
 */
class Su_Data {


	/**
	 * Constructor
	 */
	function __construct() {}


	/**
	 * Shortcode groups
	 */
	public static function groups() {
		return ( array ) apply_filters( 'su/data/groups', array(
				'all'     => __( 'All', 'su' ),
				'content' => __( 'Content', 'su' ),
				'box'     => __( 'Box', 'su' ),
				'media'   => __( 'Media', 'su' ),
				'gallery' => __( 'Gallery', 'su' ),
				'data'    => __( 'Data', 'su' ),
				'other'   => __( 'Other', 'su' )
			) );
	}


	/**
	 * Border styles
	 */
	public static function borders() {
		return ( array ) apply_filters( 'su/data/borders', array(
				'none'   => __( 'None', 'su' ),
				'solid'  => __( 'Solid', 'su' ),
				'dotted' => __( 'Dotted', 'su' ),
				'dashed' => __( 'Dashed', 'su' ),
				'double' => __( 'Double', 'su' ),
				'groove' => __( 'Groove', 'su' ),
				'ridge'  => __( 'Ridge', 'su' )
			) );
	}


	/**
	 * Font-Awesome icons
	 */
	public static function icons() {
		return apply_filters( 'su/data/icons', array( 'glass', 'music', 'search', 'envelope-o', 'heart', 'star', 'star-o', 'user', 'film', 'th-large', 'th', 'th-list', 'check', 'times', 'search-plus', 'search-minus', 'power-off', 'signal', 'cog', 'trash-o', 'home', 'file-o', 'clock-o', 'road', 'download', 'arrow-circle-o-down', 'arrow-circle-o-up', 'inbox', 'play-circle-o', 'repeat', 'refresh', 'list-alt', 'lock', 'flag', 'headphones', 'volume-off', 'volume-down', 'volume-up', 'qrcode', 'barcode', 'tag', 'tags', 'book', 'bookmark', 'print', 'camera', 'font', 'bold', 'italic', 'text-height', 'text-width', 'align-left', 'align-center', 'align-right', 'align-justify', 'list', 'outdent', 'indent', 'video-camera', 'picture-o', 'pencil', 'map-marker', 'adjust', 'tint', 'pencil-square-o', 'share-square-o', 'check-square-o', 'arrows', 'step-backward', 'fast-backward', 'backward', 'play', 'pause', 'stop', 'forward', 'fast-forward', 'step-forward', 'eject', 'chevron-left', 'chevron-right', 'plus-circle', 'minus-circle', 'times-circle', 'check-circle', 'question-circle', 'info-circle', 'crosshairs', 'times-circle-o', 'check-circle-o', 'ban', 'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'share', 'expand', 'compress', 'plus', 'minus', 'asterisk', 'exclamation-circle', 'gift', 'leaf', 'fire', 'eye', 'eye-slash', 'exclamation-triangle', 'plane', 'calendar', 'random', 'comment', 'magnet', 'chevron-up', 'chevron-down', 'retweet', 'shopping-cart', 'folder', 'folder-open', 'arrows-v', 'arrows-h', 'bar-chart-o', 'twitter-square', 'facebook-square', 'camera-retro', 'key', 'cogs', 'comments', 'thumbs-o-up', 'thumbs-o-down', 'star-half', 'heart-o', 'sign-out', 'linkedin-square', 'thumb-tack', 'external-link', 'sign-in', 'trophy', 'github-square', 'upload', 'lemon-o', 'phone', 'square-o', 'bookmark-o', 'phone-square', 'twitter', 'facebook', 'github', 'unlock', 'credit-card', 'rss', 'hdd-o', 'bullhorn', 'bell', 'certificate', 'hand-o-right', 'hand-o-left', 'hand-o-up', 'hand-o-down', 'arrow-circle-left', 'arrow-circle-right', 'arrow-circle-up', 'arrow-circle-down', 'globe', 'wrench', 'tasks', 'filter', 'briefcase', 'arrows-alt', 'users', 'link', 'cloud', 'flask', 'scissors', 'files-o', 'paperclip', 'floppy-o', 'square', 'bars', 'list-ul', 'list-ol', 'strikethrough', 'underline', 'table', 'magic', 'truck', 'pinterest', 'pinterest-square', 'google-plus-square', 'google-plus', 'money', 'caret-down', 'caret-up', 'caret-left', 'caret-right', 'columns', 'sort', 'sort-asc', 'sort-desc', 'envelope', 'linkedin', 'undo', 'gavel', 'tachometer', 'comment-o', 'comments-o', 'bolt', 'sitemap', 'umbrella', 'clipboard', 'lightbulb-o', 'exchange', 'cloud-download', 'cloud-upload', 'user-md', 'stethoscope', 'suitcase', 'bell-o', 'coffee', 'cutlery', 'file-text-o', 'building-o', 'hospital-o', 'ambulance', 'medkit', 'fighter-jet', 'beer', 'h-square', 'plus-square', 'angle-double-left', 'angle-double-right', 'angle-double-up', 'angle-double-down', 'angle-left', 'angle-right', 'angle-up', 'angle-down', 'desktop', 'laptop', 'tablet', 'mobile', 'circle-o', 'quote-left', 'quote-right', 'spinner', 'circle', 'reply', 'github-alt', 'folder-o', 'folder-open-o', 'smile-o', 'frown-o', 'meh-o', 'gamepad', 'keyboard-o', 'flag-o', 'flag-checkered', 'terminal', 'code', 'reply-all', 'mail-reply-all', 'star-half-o', 'location-arrow', 'crop', 'code-fork', 'chain-broken', 'question', 'info', 'exclamation', 'superscript', 'subscript', 'eraser', 'puzzle-piece', 'microphone', 'microphone-slash', 'shield', 'calendar-o', 'fire-extinguisher', 'rocket', 'maxcdn', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'chevron-circle-down', 'html5', 'css3', 'anchor', 'unlock-alt', 'bullseye', 'ellipsis-h', 'ellipsis-v', 'rss-square', 'play-circle', 'ticket', 'minus-square', 'minus-square-o', 'level-up', 'level-down', 'check-square', 'pencil-square', 'external-link-square', 'share-square', 'compass', 'caret-square-o-down', 'caret-square-o-up', 'caret-square-o-right', 'eur', 'gbp', 'usd', 'inr', 'jpy', 'rub', 'krw', 'btc', 'file', 'file-text', 'sort-alpha-asc', 'sort-alpha-desc', 'sort-amount-asc', 'sort-amount-desc', 'sort-numeric-asc', 'sort-numeric-desc', 'thumbs-up', 'thumbs-down', 'youtube-square', 'youtube', 'xing', 'xing-square', 'youtube-play', 'dropbox', 'stack-overflow', 'instagram', 'flickr', 'adn', 'bitbucket', 'bitbucket-square', 'tumblr', 'tumblr-square', 'long-arrow-down', 'long-arrow-up', 'long-arrow-left', 'long-arrow-right', 'apple', 'windows', 'android', 'linux', 'dribbble', 'skype', 'foursquare', 'trello', 'female', 'male', 'gittip', 'sun-o', 'moon-o', 'archive', 'bug', 'vk', 'weibo', 'renren', 'pagelines', 'stack-exchange', 'arrow-circle-o-right', 'arrow-circle-o-left', 'caret-square-o-left', 'dot-circle-o', 'wheelchair', 'vimeo-square', 'try', 'plus-square-o' ) );
	}


	/**
	 * Animate.css animations
	 */
	public static function animations() {
		return apply_filters( 'su/data/animations', array( 'flash', 'bounce', 'shake', 'tada', 'swing', 'wobble', 'pulse', 'flip', 'flipInX', 'flipOutX', 'flipInY', 'flipOutY', 'fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInUpBig', 'fadeInDownBig', 'fadeInLeftBig', 'fadeInRightBig', 'fadeOut', 'fadeOutUp', 'fadeOutDown', 'fadeOutLeft', 'fadeOutRight', 'fadeOutUpBig', 'fadeOutDownBig', 'fadeOutLeftBig', 'fadeOutRightBig', 'slideInDown', 'slideInLeft', 'slideInRight', 'slideOutUp', 'slideOutLeft', 'slideOutRight', 'bounceIn', 'bounceInDown', 'bounceInUp', 'bounceInLeft', 'bounceInRight', 'bounceOut', 'bounceOutDown', 'bounceOutUp', 'bounceOutLeft', 'bounceOutRight', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'lightSpeedIn', 'lightSpeedOut', 'hinge', 'rollIn', 'rollOut' ) );
	}


	/**
	 * Examples section
	 */
	public static function examples() {
		return ( array ) apply_filters( 'su/data/examples', array(
				'basic' => array(
					'title' => __( 'Basic examples', 'su' ),
					'items' => array(
						array(
							'name' => __( 'Accordions, spoilers, different styles, anchors', 'su' ),
							'id'   => 'spoilers',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/spoilers.example',
							'icon' => 'tasks'
						),
						array(
							'name' => __( 'Tabs, vertical tabs, tab anchors', 'su' ),
							'id'   => 'tabs',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/tabs.example',
							'icon' => 'folder'
						),
						array(
							'name' => __( 'Column layouts', 'su' ),
							'id'   => 'columns',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/columns.example',
							'icon' => 'th-large'
						),
						array(
							'name' => __( 'Media elements, YouTube, Vimeo, Screenr and self-hosted videos, audio player', 'su' ),
							'id'   => 'media',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/media.example',
							'icon' => 'play-circle'
						),
						array(
							'name' => __( 'Unlimited buttons', 'su' ),
							'id'   => 'buttons',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/buttons.example',
							'icon' => 'heart'
						),
						array(
							'name' => __( 'Animations', 'su' ),
							'id'   => 'animations',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/animations.example',
							'icon' => 'bolt'
						),
					)
				),
				'advanced' => array(
					'title' => __( 'Advanced examples', 'su' ),
					'items' => array(
						array(
							'name' => __( 'Interacting with posts shortcode', 'su' ),
							'id' => 'posts',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/posts.example',
							'icon' => 'list'
						),
						array(
							'name' => __( 'Nested shortcodes, shortcodes inside of attributes', 'su' ),
							'id' => 'nested',
							'code' => plugin_dir_path( SU_PLUGIN_FILE ) . '/inc/examples/nested.example',
							'icon' => 'indent'
						),
					)
				),
			) );
	}


	/**
	 * Shortcodes
	 */
	public static function shortcodes( $shortcode = false ) {
		$shortcodes = apply_filters( 'su/data/shortcodes', array(
				// heading
				'heading' => array(
					'name' => __( 'Heading', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => sprintf( '%s. <a href="http://gndev.info/shortcodes-ultimate/skins/" target="_blank">%s</a>', __( 'Choose style for this heading', 'su' ), __( 'Install additional styles', 'su' ) )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 7,
							'max' => 48,
							'step' => 1,
							'default' => 13,
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Select heading size (pixels)', 'su' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'su' ),
								'center' => __( 'Center', 'su' ),
								'right' => __( 'Right', 'su' )
							),
							'default' => 'center',
							'name' => __( 'Align', 'su' ),
							'desc' => __( 'Heading text alignment', 'su' )
						),
						'margin' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 200,
							'step' => 10,
							'default' => 20,
							'name' => __( 'Margin', 'su' ),
							'desc' => __( 'Bottom margin (pixels)', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Heading text', 'su' ),
					'desc' => __( 'Styled heading', 'su' ),
					'icon' => 'h-square'
				),
				// tabs
				'tabs' => array(
					'name' => __( 'Tabs', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => sprintf( '%s. <a href="http://gndev.info/shortcodes-ultimate/skins/" target="_blank">%s</a>', __( 'Choose style for this tabs', 'su' ), __( 'Install additional styles', 'su' ) )
						),
						'active' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 100,
							'step' => 1,
							'default' => 1,
							'name' => __( 'Active tab', 'su' ),
							'desc' => __( 'Select which tab is open by default', 'su' )
						),
						'vertical' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Vertical', 'su' ),
							'desc' => __( 'Show tabs vertically', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( "[%prefix_tab title=\"Title 1\"]Content 1[/%prefix_tab]\n[%prefix_tab title=\"Title 2\"]Content 2[/%prefix_tab]\n[%prefix_tab title=\"Title 3\"]Content 3[/%prefix_tab]", 'su' ),
					'desc' => __( 'Tabs container', 'su' ),
					'icon' => 'list-alt'
				),
				// tab
				'tab' => array(
					'name' => __( 'Tab', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'default' => __( 'Tab name', 'su' ),
							'name' => __( 'Title', 'su' ),
							'desc' => __( 'Enter tab name', 'su' )
						),
						'disabled' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Disabled', 'su' ),
							'desc' => __( 'Is this tab disabled', 'su' )
						),
						'anchor' => array(
							'default' => '',
							'name' => __( 'Anchor', 'su' ),
							'desc' => __( 'You can use unique anchor for this tab to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This tab will be activated and scrolled in', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Tab content', 'su' ),
					'desc' => __( 'Single tab', 'su' ),
					'icon' => 'list-alt'
				),
				// spoiler
				'spoiler' => array(
					'name' => __( 'Spoiler', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'default' => __( 'Spoiler title', 'su' ),
							'name' => __( 'Title', 'su' ), 'desc' => __( 'Text in spoiler title', 'su' )
						),
						'open' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Open', 'su' ),
							'desc' => __( 'Is spoiler content visible by default', 'su' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'fancy' => __( 'Fancy', 'su' ),
								'simple' => __( 'Simple', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => sprintf( '%s. <a href="http://gndev.info/shortcodes-ultimate/skins/" target="_blank">%s</a>', __( 'Choose style for this spoiler', 'su' ), __( 'Install additional styles', 'su' ) )
						),
						'icon' => array(
							'type' => 'select',
							'values' => array(
								'plus'           => __( 'Plus', 'su' ),
								'plus-circle'    => __( 'Plus circle', 'su' ),
								'plus-square-1'  => __( 'Plus square 1', 'su' ),
								'plus-square-2'  => __( 'Plus square 2', 'su' ),
								'arrow'          => __( 'Arrow', 'su' ),
								'arrow-circle-1' => __( 'Arrow circle 1', 'su' ),
								'arrow-circle-2' => __( 'Arrow circle 2', 'su' ),
								'chevron'        => __( 'Chevron', 'su' ),
								'chevron-circle' => __( 'Chevron circle', 'su' ),
								'caret'          => __( 'Caret', 'su' ),
								'caret-square'   => __( 'Caret square', 'su' ),
								'folder-1'       => __( 'Folder 1', 'su' ),
								'folder-2'       => __( 'Folder 2', 'su' )
							),
							'default' => 'plus',
							'name' => __( 'Icon', 'su' ),
							'desc' => __( 'Icons for spoiler', 'su' )
						),
						'anchor' => array(
							'default' => '',
							'name' => __( 'Anchor', 'su' ),
							'desc' => __( 'You can use unique anchor for this spoiler to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This spoiler will be open and scrolled in', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Hidden content', 'su' ),
					'desc' => __( 'Spoiler with hidden content', 'su' ),
					'icon' => 'list-ul'
				),
				// accordion
				'accordion' => array(
					'name' => __( 'Accordion', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( "[%prefix_spoiler]Content[/%prefix_spoiler]\n[%prefix_spoiler]Content[/%prefix_spoiler]\n[%prefix_spoiler]Content[/%prefix_spoiler]", 'su' ),
					'desc' => __( 'Accordion with spoilers', 'su' ),
					'icon' => 'list'
				),
				// divider
				'divider' => array(
					'name' => __( 'Divider', 'su' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'top' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show TOP link', 'su' ),
							'desc' => __( 'Show link to top of the page or not', 'su' )
						),
						'text' => array(
							'values' => array( ),
							'default' => __( 'Go to top', 'su' ),
							'name' => __( 'Link text', 'su' ), 'desc' => __( 'Text for the GO TOP link', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Content divider with optional TOP link', 'su' ),
					'icon' => 'ellipsis-h'
				),
				// spacer
				'spacer' => array(
					'name' => __( 'Spacer', 'su' ),
					'type' => 'single',
					'group' => 'content other',
					'atts' => array(
						'size' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 800,
							'step' => 10,
							'default' => 20,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Height of the spacer in pixels', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Empty space with adjustable height', 'su' ),
					'icon' => 'arrows-v'
				),
				// highlight
				'highlight' => array(
					'name' => __( 'Highlight', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'background' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#DDFF99',
							'name' => __( 'Background', 'su' ),
							'desc' => __( 'Highlighted text background color', 'su' )
						),
						'color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#000000',
							'name' => __( 'Text color', 'su' ), 'desc' => __( 'Highlighted text color', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Highlighted text', 'su' ),
					'desc' => __( 'Highlighted text', 'su' ),
					'icon' => 'pencil'
				),
				// label
				'label' => array(
					'name' => __( 'Label', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'success' => __( 'Success', 'su' ),
								'warning' => __( 'Warning', 'su' ),
								'important' => __( 'Important', 'su' ),
								'black' => __( 'Black', 'su' ),
								'info' => __( 'Info', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Type', 'su' ),
							'desc' => __( 'Style of the label', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Label', 'su' ),
					'desc' => __( 'Styled label', 'su' ),
					'icon' => 'tag'
				),
				// quote
				'quote' => array(
					'name' => __( 'Quote', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => sprintf( '%s. <a href="http://gndev.info/shortcodes-ultimate/skins/" target="_blank">%s</a>', __( 'Choose style for this quote', 'su' ), __( 'Install additional styles', 'su' ) )
						),
						'cite' => array(
							'default' => '',
							'name' => __( 'Cite', 'su' ),
							'desc' => __( 'Quote author name', 'su' )
						),
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Cite url', 'su' ),
							'desc' => __( 'Url of the quote author. Leave empty to disable link', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Quote', 'su' ),
					'desc' => __( 'Blockquote alternative', 'su' ),
					'icon' => 'quote-right'
				),
				// pullquote
				'pullquote' => array(
					'name' => __( 'Pullquote', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'su' ),
								'right' => __( 'Right', 'su' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'su' ), 'desc' => __( 'Pullquote alignment (float)', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Pullquote', 'su' ),
					'desc' => __( 'Pullquote', 'su' ),
					'icon' => 'quote-left'
				),
				// dropcap
				'dropcap' => array(
					'name' => __( 'Dropcap', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'flat' => __( 'Flat', 'su' ),
								'light' => __( 'Light', 'su' ),
								'simple' => __( 'Simple', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ), 'desc' => __( 'Dropcap style preset', 'su' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 5,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Choose dropcap size', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'D', 'su' ),
					'desc' => __( 'Dropcap', 'su' ),
					'icon' => 'bold'
				),
				// frame
				'frame' => array(
					'name' => __( 'Frame', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'su' ),
								'center' => __( 'Center', 'su' ),
								'right' => __( 'Right', 'su' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'su' ),
							'desc' => __( 'Frame alignment', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => '<img src="http://lorempixel.com/g/400/200/" />',
					'desc' => __( 'Styled image frame', 'su' ),
					'icon' => 'picture-o'
				),
				// row
				'row' => array(
					'name' => __( 'Row', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( "[%prefix_column size=\"1/3\"]Content[/%prefix_column]\n[%prefix_column size=\"1/3\"]Content[/%prefix_column]\n[%prefix_column size=\"1/3\"]Content[/%prefix_column]", 'su' ),
					'desc' => __( 'Row for flexible columns', 'su' ),
					'icon' => 'columns'
				),
				// column
				'column' => array(
					'name' => __( 'Column', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'size' => array(
							'type' => 'select',
							'values' => array(
								'1/1' => __( 'Full width', 'su' ),
								'1/2' => __( 'One half', 'su' ),
								'1/3' => __( 'One third', 'su' ),
								'2/3' => __( 'Two third', 'su' ),
								'1/4' => __( 'One fourth', 'su' ),
								'3/4' => __( 'Three fourth', 'su' ),
								'1/5' => __( 'One fifth', 'su' ),
								'2/5' => __( 'Two fifth', 'su' ),
								'3/5' => __( 'Three fifth', 'su' ),
								'4/5' => __( 'Four fifth', 'su' ),
								'1/6' => __( 'One sixth', 'su' ),
								'5/6' => __( 'Five sixth', 'su' )
							),
							'default' => '1/2',
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Select column width. This width will be calculated depend page width', 'su' )
						),
						'center' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Centered', 'su' ),
							'desc' => __( 'Is this column centered on the page', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Column content', 'su' ),
					'desc' => __( 'Flexible and responsive columns', 'su' ),
					'icon' => 'columns'
				),
				// list
				'list' => array(
					'name' => __( 'List', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'su' ),
							'desc' => __( 'You can upload custom icon for this list or pick a built-in icon', 'su' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Icon color', 'su' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( "<ul>\n<li>List item</li>\n<li>List item</li>\n<li>List item</li>\n</ul>", 'su' ),
					'desc' => __( 'Styled unordered list', 'su' ),
					'icon' => 'list-ol'
				),
				// button
				'button' => array(
					'name' => __( 'Button', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => get_option( 'home' ),
							'name' => __( 'Link', 'su' ),
							'desc' => __( 'Button link', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same tab', 'su' ),
								'blank' => __( 'New tab', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'su' ),
							'desc' => __( 'Button link target', 'su' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'flat' => __( 'Flat', 'su' ),
								'soft' => __( 'Soft', 'su' ),
								'glass' => __( 'Glass', 'su' ),
								'bubbles' => __( 'Bubbles', 'su' ),
								'noise' => __( 'Noise', 'su' ),
								'stroked' => __( 'Stroked', 'su' ),
								'3d' => __( '3D', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ), 'desc' => __( 'Button background style preset', 'su' )
						),
						'background' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#2D89EF',
							'name' => __( 'Background', 'su' ), 'desc' => __( 'Button background color', 'su' )
						),
						'color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFFFF',
							'name' => __( 'Text color', 'su' ),
							'desc' => __( 'Button text color', 'su' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Button size', 'su' )
						),
						'wide' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Fluid', 'su' ), 'desc' => __( 'Fluid buttons has 100% width', 'su' )
						),
						'center' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Centered', 'su' ), 'desc' => __( 'Is button centered on the page', 'su' )
						),
						'radius' => array(
							'type' => 'select',
							'values' => array(
								'auto' => __( 'Auto', 'su' ),
								'round' => __( 'Round', 'su' ),
								'0' => __( 'Square', 'su' ),
								'5' => '5px',
								'10' => '10px',
								'20' => '20px'
							),
							'default' => 'auto',
							'name' => __( 'Radius', 'su' ),
							'desc' => __( 'Radius of button corners. Auto-radius calculation based on button size', 'su' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'su' ),
							'desc' => __( 'You can upload custom icon for this button or pick a built-in icon', 'su' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Icon color', 'su' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'su' )
						),
						'text_shadow' => array(
							'type' => 'shadow',
							'default' => 'none',
							'name' => __( 'Text shadow', 'su' ),
							'desc' => __( 'Button text shadow', 'su' )
						),
						'desc' => array(
							'default' => '',
							'name' => __( 'Description', 'su' ),
							'desc' => __( 'Small description under button text. This option is incompatible with icon.', 'su' )
						),
						'onclick' => array(
							'default' => '',
							'name' => __( 'onClick', 'su' ),
							'desc' => __( 'Advanced JavaScript code for onClick action', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Button text', 'su' ),
					'desc' => __( 'Styled button', 'su' ),
					'icon' => 'heart'
				),
				// service
				'service' => array(
					'name' => __( 'Service', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Service title', 'su' ),
							'name' => __( 'Title', 'su' ),
							'desc' => __( 'Service name', 'su' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'su' ),
							'desc' => __( 'You can upload custom icon for this box', 'su' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Icon color', 'su' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'su' )
						),
						'size' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 128,
							'step' => 2,
							'default' => 32,
							'name' => __( 'Icon size', 'su' ),
							'desc' => __( 'Size of the uploaded icon in pixels', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Service description', 'su' ),
					'desc' => __( 'Service box with title', 'su' ),
					'icon' => 'check-square-o'
				),
				// box
				'box' => array(
					'name' => __( 'Box', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Box title', 'su' ),
							'name' => __( 'Title', 'su' ), 'desc' => __( 'Text for the box title', 'su' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'soft' => __( 'Soft', 'su' ),
								'glass' => __( 'Glass', 'su' ),
								'bubbles' => __( 'Bubbles', 'su' ),
								'noise' => __( 'Noise', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => __( 'Box style preset', 'su' )
						),
						'box_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Color', 'su' ),
							'desc' => __( 'Color for the box title and borders', 'su' )
						),
						'title_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFFFF',
							'name' => __( 'Title text color', 'su' ), 'desc' => __( 'Color for the box title text', 'su' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Radius', 'su' ),
							'desc' => __( 'Box corners radius', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Box content', 'su' ),
					'desc' => __( 'Colored box with caption', 'su' ),
					'icon' => 'list-alt'
				),
				// note
				'note' => array(
					'name' => __( 'Note', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'note_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFF66',
							'name' => __( 'Background', 'su' ), 'desc' => __( 'Note background color', 'su' )
						),
						'text_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Text color', 'su' ),
							'desc' => __( 'Note text color', 'su' )
						),
						'radius' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Radius', 'su' ), 'desc' => __( 'Note corners radius', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Note text', 'su' ),
					'desc' => __( 'Colored box', 'su' ),
					'icon' => 'list-alt'
				),
				// lightbox
				'lightbox' => array(
					'name' => __( 'Lightbox', 'su' ),
					'type' => 'wrap',
					'group' => 'gallery',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'iframe' => __( 'Iframe', 'su' ),
								'image' => __( 'Image', 'su' ),
								'inline' => __( 'Inline (html content)', 'su' )
							),
							'default' => 'iframe',
							'name' => __( 'Content type', 'su' ),
							'desc' => __( 'Select type of the lightbox window content', 'su' )
						),
						'src' => array(
							'default' => '',
							'name' => __( 'Content source', 'su' ),
							'desc' => __( 'Insert here URL or CSS selector. Use URL for Iframe and Image content types. Use CSS selector for Inline content type.<br />Example values:<br /><b%value>http://www.youtube.com/watch?v=XXXXXXXXX</b> - YouTube video (iframe)<br /><b%value>http://example.com/wp-content/uploads/image.jpg</b> - uploaded image (image)<br /><b%value>http://example.com/</b> - any web page (iframe)<br /><b%value>#contact-form</b> - any HTML content (inline)', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( '[%prefix_button] Click Here to Watch the Video [/%prefix_button]', 'su' ),
					'desc' => __( 'Lightbox window with custom content', 'su' ),
					'icon' => 'external-link'
				),
				// tooltip
				'tooltip' => array(
					'name' => __( 'Tooltip', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'light' => __( 'Basic: Light', 'su' ),
								'dark' => __( 'Basic: Dark', 'su' ),
								'yellow' => __( 'Basic: Yellow', 'su' ),
								'green' => __( 'Basic: Green', 'su' ),
								'red' => __( 'Basic: Red', 'su' ),
								'blue' => __( 'Basic: Blue', 'su' ),
								'youtube' => __( 'Youtube', 'su' ),
								'tipsy' => __( 'Tipsy', 'su' ),
								'bootstrap' => __( 'Bootstrap', 'su' ),
								'jtools' => __( 'jTools', 'su' ),
								'tipped' => __( 'Tipped', 'su' ),
								'cluetip' => __( 'Cluetip', 'su' ),
							),
							'default' => 'yellow',
							'name' => __( 'Style', 'su' ),
							'desc' => __( 'Tooltip window style', 'su' )
						),
						'position' => array(
							'type' => 'select',
							'values' => array(
								'north' => __( 'Top', 'su' ),
								'south' => __( 'Bottom', 'su' ),
								'west' => __( 'Left', 'su' ),
								'east' => __( 'Right', 'su' )
							),
							'default' => 'top',
							'name' => __( 'Position', 'su' ),
							'desc' => __( 'Tooltip position', 'su' )
						),
						'shadow' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Shadow', 'su' ),
							'desc' => __( 'Add shadow to tooltip. This option is only works with basic styes, e.g. blue, green etc.', 'su' )
						),
						'rounded' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Rounded corners', 'su' ),
							'desc' => __( 'Use rounded for tooltip. This option is only works with basic styes, e.g. blue, green etc.', 'su' )
						),
						'size' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'1' => 1,
								'2' => 2,
								'3' => 3,
								'4' => 4,
								'5' => 5,
								'6' => 6,
							),
							'default' => 'default',
							'name' => __( 'Font size', 'su' ),
							'desc' => __( 'Tooltip font size', 'su' )
						),
						'title' => array(
							'default' => '',
							'name' => __( 'Tooltip title', 'su' ),
							'desc' => __( 'Enter title for tooltip window. Leave this field empty to hide the title', 'su' )
						),
						'content' => array(
							'default' => __( 'Tooltip text', 'su' ),
							'name' => __( 'Tooltip content', 'su' ),
							'desc' => __( 'Enter tooltip content here', 'su' )
						),
						'behavior' => array(
							'type' => 'select',
							'values' => array(
								'hover' => __( 'Show and hide on mouse hover', 'su' ),
								'click' => __( 'Show and hide by mouse click', 'su' ),
								'always' => __( 'Always visible', 'su' )
							),
							'default' => 'hover',
							'name' => __( 'Behavior', 'su' ),
							'desc' => __( 'Select tooltip behavior', 'su' )
						),
						'close' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Close button', 'su' ),
							'desc' => __( 'Show close button', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( '[%prefix_button] Hover me to open tooltip [/%prefix_button]', 'su' ),
					'desc' => __( 'Tooltip window with custom content', 'su' ),
					'icon' => 'comment-o'
				),
				// private
				'private' => array(
					'name' => __( 'Private', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Private note text', 'su' ),
					'desc' => __( 'Private note for post authors', 'su' ),
					'icon' => 'lock'
				),
				// youtube
				'youtube' => array(
					'name' => __( 'YouTube', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url of YouTube page with video. Ex: http://youtube.com/watch?v=XXXXXX', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play video automatically when page is loaded', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'YouTube video', 'su' ),
					'icon' => 'youtube-play'
				),
				// youtube_advanced
				'youtube_advanced' => array(
					'name' => __( 'YouTube Advanced', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url of YouTube page with video. Ex: http://youtube.com/watch?v=XXXXXX', 'su' )
						),
						'playlist' => array(
							'default' => '',
							'name' => __( 'Playlist', 'su' ),
							'desc' => __( 'Value is a comma-separated list of video IDs to play. If you specify a value, the first video that plays will be the VIDEO_ID specified in the URL path, and the videos specified in the playlist parameter will play thereafter', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'controls' => array(
							'type' => 'select',
							'values' => array(
								'no' => __( '0 - Hide controls', 'su' ),
								'yes' => __( '1 - Show controls', 'su' ),
								'alt' => __( '2 - Show controls when playback is started', 'su' )
							),
							'default' => 'yes',
							'name' => __( 'Controls', 'su' ),
							'desc' => __( 'This parameter indicates whether the video player controls will display', 'su' )
						),
						'autohide' => array(
							'type' => 'select',
							'values' => array(
								'no' => __( '0 - Do not hide controls', 'su' ),
								'yes' => __( '1 - Hide all controls on mouse out', 'su' ),
								'alt' => __( '2 - Hide progress bar on mouse out', 'su' )
							),
							'default' => 'alt',
							'name' => __( 'Autohide', 'su' ),
							'desc' => __( 'This parameter indicates whether the video controls will automatically hide after a video begins playing', 'su' )
						),
						'showinfo' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show title bar', 'su' ),
							'desc' => __( 'If you set the parameter value to NO, then the player will not display information like the video title and uploader before the video starts playing.', 'su' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play video automatically when page is loaded', 'su' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'su' ),
							'desc' => __( 'Setting of YES will cause the player to play the initial video again and again', 'su' )
						),
						'rel' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Related videos', 'su' ),
							'desc' => __( 'This parameter indicates whether the player should show related videos when playback of the initial video ends', 'su' )
						),
						'fs' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show full-screen button', 'su' ),
							'desc' => __( 'Setting this parameter to NO prevents the fullscreen button from displaying', 'su' )
						),
						'modestbranding' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => 'modestbranding',
							'desc' => __( 'This parameter lets you use a YouTube player that does not show a YouTube logo. Set the parameter value to YES to prevent the YouTube logo from displaying in the control bar. Note that a small YouTube text label will still display in the upper-right corner of a paused video when the user\'s mouse pointer hovers over the player', 'su' )
						),
						'theme' => array(
							'type' => 'select',
							'values' => array(
								'dark' => __( 'Dark theme', 'su' ),
								'light' => __( 'Light theme', 'su' )
							),
							'default' => 'dark',
							'name' => __( 'Theme', 'su' ),
							'desc' => __( 'This parameter indicates whether the embedded player will display player controls (like a play button or volume control) within a dark or light control bar', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'YouTube video player with advanced settings', 'su' ),
					'icon' => 'youtube-play'
				),
				// vimeo
				'vimeo' => array(
					'name' => __( 'Vimeo', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'su' ), 'desc' => __( 'Url of Vimeo page with video', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play video automatically when page is loaded', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Vimeo video', 'su' ),
					'icon' => 'youtube-play'
				),
				// screenr
				'screenr' => array(
					'name' => __( 'Screenr', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'default' => '',
							'name' => __( 'Url', 'su' ), 'desc' => __( 'Url of Screenr page with video', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Screenr video', 'su' ),
					'icon' => 'youtube-play'
				),
				// audio
				'audio' => array(
					'name' => __( 'Audio', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'File', 'su' ),
							'desc' => __( 'Audio file url. Supported formats: mp3, ogg', 'su' )
						),
						'width' => array(
							'values' => array(),
							'default' => '100%',
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width. You can specify width in percents and player will be responsive. Example values: <b%value>200px</b>, <b%value>100&#37;</b>', 'su' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play file automatically when page is loaded', 'su' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'su' ),
							'desc' => __( 'Repeat when playback is ended', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Custom audio player', 'su' ),
					'icon' => 'play-circle'
				),
				// video
				'video' => array(
					'name' => __( 'Video', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'File', 'su' ),
							'desc' => __( 'Url to mp4/flv video-file', 'su' )
						),
						'poster' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Poster', 'su' ),
							'desc' => __( 'Url to poster image, that will be shown before playback', 'su' )
						),
						'title' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Title', 'su' ),
							'desc' => __( 'Player title', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 300,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'controls' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Controls', 'su' ),
							'desc' => __( 'Show player controls (play/pause etc.) or not', 'su' )
						),
						'autoplay' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play file automatically when page is loaded', 'su' )
						),
						'loop' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Loop', 'su' ),
							'desc' => __( 'Repeat when playback is ended', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Custom video player', 'su' ),
					'icon' => 'play-circle'
				),
				// table
				'table' => array(
					'name' => __( 'Table', 'su' ),
					'type' => 'mixed',
					'group' => 'content',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'CSV file', 'su' ),
							'desc' => __( 'Upload CSV file if you want to create HTML-table from file', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( "<table>\n<tr>\n\t<td>Table</td>\n\t<td>Table</td>\n</tr>\n<tr>\n\t<td>Table</td>\n\t<td>Table</td>\n</tr>\n</table>", 'su' ),
					'desc' => __( 'Styled table from HTML or CSV file', 'su' ),
					'icon' => 'table'
				),
				// permalink
				'permalink' => array(
					'name' => __( 'Permalink', 'su' ),
					'type' => 'mixed',
					'group' => 'content other',
					'atts' => array(
						'id' => array(
							'values' => array( ), 'default' => 1,
							'name' => __( 'ID', 'su' ),
							'desc' => __( 'Post or page ID', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same tab', 'su' ),
								'blank' => __( 'New tab', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'su' ),
							'desc' => __( 'Link target. blank - link will be opened in new window/tab', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => '',
					'desc' => __( 'Permalink to specified post/page', 'su' ),
					'icon' => 'link'
				),
				// members
				'members' => array(
					'name' => __( 'Members', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'message' => array(
							'default' => __( 'This content is for registered users only. Please %login%.', 'su' ),
							'name' => __( 'Message', 'su' ), 'desc' => __( 'Message for not logged users', 'su' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#ffcc00',
							'name' => __( 'Box color', 'su' ), 'desc' => __( 'This color will applied only to box for not logged users', 'su' )
						),
						'login_text' => array(
							'default' => __( 'login', 'su' ),
							'name' => __( 'Login link text', 'su' ), 'desc' => __( 'Text for the login link', 'su' )
						),
						'login_url' => array(
							'default' => wp_login_url(),
							'name' => __( 'Login link url', 'su' ), 'desc' => __( 'Login link url', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Content for logged members', 'su' ),
					'desc' => __( 'Content for logged in members only', 'su' ),
					'icon' => 'lock'
				),
				// guests
				'guests' => array(
					'name' => __( 'Guests', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Content for guests', 'su' ),
					'desc' => __( 'Content for guests only', 'su' ),
					'icon' => 'user'
				),
				// feed
				'feed' => array(
					'name' => __( 'RSS Feed', 'su' ),
					'type' => 'single',
					'group' => 'content other',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url to RSS-feed', 'su' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Limit', 'su' ), 'desc' => __( 'Number of items to show', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Feed grabber', 'su' ),
					'icon' => 'rss'
				),
				// menu
				'menu' => array(
					'name' => __( 'Menu', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'name' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Menu name', 'su' ), 'desc' => __( 'Custom menu name. Ex: Main menu', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Custom menu by name', 'su' ),
					'icon' => 'bars'
				),
				// subpages
				'subpages' => array(
					'name' => __( 'Sub pages', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3, 4, 5 ), 'default' => 1,
							'name' => __( 'Depth', 'su' ),
							'desc' => __( 'Max depth level of children pages', 'su' )
						),
						'p' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Parent ID', 'su' ),
							'desc' => __( 'ID of the parent page. Leave blank to use current page', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'List of sub pages', 'su' ),
					'icon' => 'bars'
				),
				// siblings
				'siblings' => array(
					'name' => __( 'Siblings', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3 ), 'default' => 1,
							'name' => __( 'Depth', 'su' ),
							'desc' => __( 'Max depth level', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'List of cureent page siblings', 'su' ),
					'icon' => 'bars'
				),
				// document
				'document' => array(
					'name' => __( 'Document', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url to uploaded document. Supported formats: doc, xls, pdf etc.', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Viewer width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Viewer height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make viewer responsive', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Document viewer by Google', 'su' ),
					'icon' => 'file-text'
				),
				// gmap
				'gmap' => array(
					'name' => __( 'Gmap', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Map width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Map height', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make map responsive', 'su' )
						),
						'address' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Marker', 'su' ),
							'desc' => __( 'Address for the marker. You can type it in any language', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Maps by Google', 'su' ),
					'icon' => 'globe'
				),
				// slider
				'slider' => array(
					'name' => __( 'Slider', 'su' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'su' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'su' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'su' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'su' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'su' ),
								'image'      => __( 'Full-size image', 'su' ),
								'attachment' => __( 'Attachment page', 'su' ),
								'post'       => __( 'Post permalink', 'su' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'su' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'su' ),
								'blank' => __( 'New window', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'su' ),
							'desc' => __( 'Open links in', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ), 'desc' => __( 'Slider width (in pixels)', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 200,
							'max' => 1600,
							'step' => 20,
							'default' => 300,
							'name' => __( 'Height', 'su' ), 'desc' => __( 'Slider height (in pixels)', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make slider responsive', 'su' )
						),
						'title' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show titles', 'su' ), 'desc' => __( 'Display slide titles', 'su' )
						),
						'centered' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Center', 'su' ), 'desc' => __( 'Is slider centered on the page', 'su' )
						),
						'arrows' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Arrows', 'su' ), 'desc' => __( 'Show left and right arrows', 'su' )
						),
						'pages' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Pagination', 'su' ),
							'desc' => __( 'Show pagination', 'su' )
						),
						'mousewheel' => array(
							'type' => 'bool',
							'default' => 'yes', 'name' => __( 'Mouse wheel control', 'su' ),
							'desc' => __( 'Allow to change slides with mouse wheel', 'su' )
						),
						'autoplay' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 100000,
							'step' => 100,
							'default' => 5000,
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Choose interval between slide animations. Set to 0 to disable autoplay', 'su' )
						),
						'speed' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 20000,
							'step' => 100,
							'default' => 600,
							'name' => __( 'Speed', 'su' ), 'desc' => __( 'Specify animation speed', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Customizable image slider', 'su' ),
					'icon' => 'picture-o'
				),
				// carousel
				'carousel' => array(
					'name' => __( 'Carousel', 'su' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'su' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'su' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'su' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'su' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'su' ),
								'image'      => __( 'Original image', 'su' ),
								'attachment' => __( 'Attachment page', 'su' ),
								'post'       => __( 'Post permalink', 'su' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'su' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'su' ),
								'blank' => __( 'New window', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'su' ),
							'desc' => __( 'Open links in', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 100,
							'max' => 1600,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Carousel width (in pixels)', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 20,
							'max' => 1600,
							'step' => 20,
							'default' => 100,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Carousel height (in pixels)', 'su' )
						),
						'responsive' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make carousel responsive', 'su' )
						),
						'items' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Items to show', 'su' ),
							'desc' => __( 'How much carousel items is visible', 'su' )
						),
						'scroll' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'step' => 1, 'default' => 1,
							'name' => __( 'Scroll number', 'su' ),
							'desc' => __( 'How much items are scrolled in one transition', 'su' )
						),
						'title' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Show titles', 'su' ), 'desc' => __( 'Display titles for each item', 'su' )
						),
						'centered' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Center', 'su' ), 'desc' => __( 'Is carousel centered on the page', 'su' )
						),
						'arrows' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Arrows', 'su' ), 'desc' => __( 'Show left and right arrows', 'su' )
						),
						'pages' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Pagination', 'su' ),
							'desc' => __( 'Show pagination', 'su' )
						),
						'mousewheel' => array(
							'type' => 'bool',
							'default' => 'yes', 'name' => __( 'Mouse wheel control', 'su' ),
							'desc' => __( 'Allow to rotate carousel with mouse wheel', 'su' )
						),
						'autoplay' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 100000,
							'step' => 100,
							'default' => 5000,
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Choose interval between auto animations. Set to 0 to disable autoplay', 'su' )
						),
						'speed' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 20000,
							'step' => 100,
							'default' => 600,
							'name' => __( 'Speed', 'su' ), 'desc' => __( 'Specify animation speed', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Customizable image carousel', 'su' ),
					'icon' => 'picture-o'
				),
				// custom_gallery
				'custom_gallery' => array(
					'name' => __( 'Gallery', 'su' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'source' => array(
							'type'    => 'image_source',
							'default' => 'none',
							'name'    => __( 'Source', 'su' ),
							'desc'    => __( 'Choose images source. You can use images from Media library or retrieve it from posts (thumbnails) posted under specified blog category. You can also pick any custom taxonomy', 'su' )
						),
						'limit' => array(
							'type' => 'slider',
							'min' => -1,
							'max' => 100,
							'step' => 1,
							'default' => 20,
							'name' => __( 'Limit', 'su' ),
							'desc' => __( 'Maximum number of image source posts (for recent posts, category and custom taxonomy)', 'su' )
						),
						'link' => array(
							'type' => 'select',
							'values' => array(
								'none'       => __( 'None', 'su' ),
								'image'      => __( 'Original image', 'su' ),
								'attachment' => __( 'Attachment page', 'su' ),
								'post'       => __( 'Post permalink', 'su' )
							),
							'default' => 'none',
							'name' => __( 'Links', 'su' ),
							'desc' => __( 'Select which links will be used for images in this gallery', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same window', 'su' ),
								'blank' => __( 'New window', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Links target', 'su' ),
							'desc' => __( 'Open links in', 'su' )
						),
						'width' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 90,
							'name' => __( 'Width', 'su' ), 'desc' => __( 'Single item width (in pixels)', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 90,
							'name' => __( 'Height', 'su' ), 'desc' => __( 'Single item height (in pixels)', 'su' )
						),
						'title' => array(
							'type' => 'select',
							'values' => array(
								'never' => __( 'Never', 'su' ),
								'hover' => __( 'On mouse over', 'su' ),
								'always' => __( 'Always', 'su' )
							),
							'default' => 'hover',
							'name' => __( 'Show titles', 'su' ),
							'desc' => __( 'Title display mode', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Customizable image gallery', 'su' ),
					'icon' => 'picture-o'
				),
				// posts
				'posts' => array(
					'name' => __( 'Posts', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'template' => array(
							'default' => 'templates/default-loop.php', 'name' => __( 'Template', 'su' ),
							'desc' => __( '<b>Do not change this field value if you do not understand description below.</b><br/>Relative path to the template file. Default templates is placed under the plugin directory (templates folder). You can copy it under your theme directory and modify as you want. You can use following default templates that already available in the plugin directory:<br/><b%value>templates/default-loop.php</b> - posts loop<br/><b%value>templates/teaser-loop.php</b> - posts loop with thumbnail and title<br/><b%value>templates/single-post.php</b> - single post template<br/><b%value>templates/list-loop.php</b> - unordered list with posts titles', 'su' )
						),
						'id' => array(
							'default' => '',
							'name' => __( 'Post ID\'s', 'su' ),
							'desc' => __( 'Enter comma separated ID\'s of the posts that you want to show', 'su' )
						),
						'posts_per_page' => array(
							'type' => 'number',
							'min' => -1,
							'max' => 10000,
							'step' => 1,
							'default' => get_option( 'posts_per_page' ),
							'name' => __( 'Posts per page', 'su' ),
							'desc' => __( 'Specify number of posts that you want to show. Enter -1 to get all posts', 'su' )
						),
						'post_type' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => Su_Tools::get_types(),
							'default' => 'post',
							'name' => __( 'Post types', 'su' ),
							'desc' => __( 'Select post types. Hold Ctrl key to select multiple post types', 'su' )
						),
						'taxonomy' => array(
							'type' => 'select',
							'values' => Su_Tools::get_taxonomies(),
							'default' => 'category',
							'name' => __( 'Taxonomy', 'su' ),
							'desc' => __( 'Select taxonomy to show posts from', 'su' )
						),
						'tax_term' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => Su_Tools::get_terms( 'category' ),
							'default' => '',
							'name' => __( 'Terms', 'su' ),
							'desc' => __( 'Select terms to show posts from', 'su' )
						),
						'tax_operator' => array(
							'type' => 'select',
							'values' => array( 'IN', 'NOT IN', 'AND' ),
							'default' => 'IN', 'name' => __( 'Taxonomy term operator', 'su' ),
							'desc' => __( 'IN - posts that have any of selected categories terms<br/>NOT IN - posts that is does not have any of selected terms<br/>AND - posts that have all selected terms', 'su' )
						),
						'author' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => Su_Tools::get_users(),
							'default' => 'default',
							'name' => __( 'Authors', 'su' ),
							'desc' => __( 'Choose the authors whose posts you want to show', 'su' )
						),
						'meta_key' => array(
							'default' => '',
							'name' => __( 'Meta key', 'su' ),
							'desc' => __( 'Enter meta key name to show posts that have this key', 'su' )
						),
						'offset' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 1, 'default' => 0,
							'name' => __( 'Offset', 'su' ),
							'desc' => __( 'Specify offset to start posts loop not from first post', 'su' )
						),
						'order' => array(
							'type' => 'select',
							'values' => array(
								'desc' => __( 'Descending', 'su' ),
								'asc' => __( 'Ascending', 'su' )
							),
							'default' => 'DESC',
							'name' => __( 'Order', 'su' ),
							'desc' => __( 'Posts order', 'su' )
						),
						'orderby' => array(
							'type' => 'select',
							'values' => array(
								'none' => __( 'None', 'su' ),
								'id' => __( 'Post ID', 'su' ),
								'author' => __( 'Post author', 'su' ),
								'title' => __( 'Post title', 'su' ),
								'name' => __( 'Post slug', 'su' ),
								'date' => __( 'Date', 'su' ), 'modified' => __( 'Last modified date', 'su' ),
								'parent' => __( 'Post parent', 'su' ),
								'rand' => __( 'Random', 'su' ), 'comment_count' => __( 'Comments number', 'su' ),
								'menu_order' => __( 'Menu order', 'su' ), 'meta_value' => __( 'Meta key values', 'su' ),
							),
							'default' => 'date',
							'name' => __( 'Order by', 'su' ),
							'desc' => __( 'Order posts by', 'su' )
						),
						'post_parent' => array(
							'default' => '',
							'name' => __( 'Post parent', 'su' ),
							'desc' => __( 'Show childrens of entered post (enter post ID)', 'su' )
						),
						'post_status' => array(
							'type' => 'select',
							'values' => array(
								'publish' => __( 'Published', 'su' ),
								'pending' => __( 'Pending', 'su' ),
								'draft' => __( 'Draft', 'su' ),
								'auto-draft' => __( 'Auto-draft', 'su' ),
								'future' => __( 'Future post', 'su' ),
								'private' => __( 'Private post', 'su' ),
								'inherit' => __( 'Inherit', 'su' ),
								'trash' => __( 'Trashed', 'su' ),
								'any' => __( 'Any', 'su' ),
							),
							'default' => 'publish',
							'name' => __( 'Post status', 'su' ),
							'desc' => __( 'Show only posts with selected status', 'su' )
						),
						'ignore_sticky_posts' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Ignore sticky', 'su' ),
							'desc' => __( 'Select Yes to ignore posts that is sticked', 'su' )
						)
					),
					'desc' => __( 'Custom posts query with customizable template', 'su' ),
					'icon' => 'th-list'
				),
				// dummy_text
				'dummy_text' => array(
					'name' => __( 'Dummy text', 'su' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'what' => array(
							'type' => 'select',
							'values' => array(
								'paras' => __( 'Paragraphs', 'su' ),
								'words' => __( 'Words', 'su' ),
								'bytes' => __( 'Bytes', 'su' ),
							),
							'default' => 'paras',
							'name' => __( 'What', 'su' ),
							'desc' => __( 'What to generate', 'su' )
						),
						'amount' => array(
							'type' => 'slider',
							'min' => 1,
							'max' => 100,
							'step' => 1,
							'default' => 1,
							'name' => __( 'Amount', 'su' ),
							'desc' => __( 'How many items (paragraphs or words) to generate. Minimum words amount is 5', 'su' )
						),
						'cache' => array(
							'type' => 'bool',
							'default' => 'yes',
							'name' => __( 'Cache', 'su' ),
							'desc' => __( 'Generated text will be cached. Be careful with this option. If you disable it and insert many dummy_text shortcodes the page load time will be highly increased', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Text placeholder', 'su' ),
					'icon' => 'text-height'
				),
				// dummy_image
				'dummy_image' => array(
					'name' => __( 'Dummy image', 'su' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'width' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 500,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Image width', 'su' )
						),
						'height' => array(
							'type' => 'slider',
							'min' => 10,
							'max' => 1600,
							'step' => 10,
							'default' => 300,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Image height', 'su' )
						),
						'theme' => array(
							'type' => 'select',
							'values' => array(
								'any'       => __( 'Any', 'su' ),
								'abstract'  => __( 'Abstract', 'su' ),
								'animals'   => __( 'Animals', 'su' ),
								'business'  => __( 'Business', 'su' ),
								'cats'      => __( 'Cats', 'su' ),
								'city'      => __( 'City', 'su' ),
								'food'      => __( 'Food', 'su' ),
								'nightlife' => __( 'Night life', 'su' ),
								'fashion'   => __( 'Fashion', 'su' ),
								'people'    => __( 'People', 'su' ),
								'nature'    => __( 'Nature', 'su' ),
								'sports'    => __( 'Sports', 'su' ),
								'technics'  => __( 'Technics', 'su' ),
								'transport' => __( 'Transport', 'su' )
							),
							'default' => 'any',
							'name' => __( 'Theme', 'su' ),
							'desc' => __( 'Select the theme for this image', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'desc' => __( 'Image placeholder with random image', 'su' ),
					'icon' => 'picture-o'
				),
				// animate
				'animate' => array(
					'name' => __( 'Animation', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array_combine( self::animations(), self::animations() ),
							'default' => 'bounceIn',
							'name' => __( 'Animation', 'su' ),
							'desc' => __( 'Select animation type', 'su' )
						),
						'duration' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 1,
							'name' => __( 'Duration', 'su' ),
							'desc' => __( 'Animation duration (seconds)', 'su' )
						),
						'delay' => array(
							'type' => 'slider',
							'min' => 0,
							'max' => 20,
							'step' => 0.5,
							'default' => 0,
							'name' => __( 'Delay', 'su' ),
							'desc' => __( 'Animation delay (seconds)', 'su' )
						),
						'inline' => array(
							'type' => 'bool',
							'default' => 'no',
							'name' => __( 'Inline', 'su' ),
							'desc' => __( 'This parameter determines what HTML tag will be used for animation wrapper. Turn this option to YES and animated element will be wrapped in SPAN instead of DIV. Useful for inline animations, like buttons', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'content' => __( 'Animated content', 'su' ),
					'desc' => __( 'Wrapper for animation. Any nested element will be animated', 'su' ),
					'icon' => 'bolt'
				),
				// meta
				'meta' => array(
					'name' => __( 'Meta', 'su' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'key' => array(
							'default' => '',
							'name' => __( 'Key', 'su' ),
							'desc' => __( 'Meta key name', 'su' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'su' ),
							'desc' => __( 'This text will be shown if data is not found', 'su' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'su' ),
							'desc' => __( 'This content will be shown before the value', 'su' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'su' ),
							'desc' => __( 'This content will be shown after the value', 'su' )
						),
						'post_id' => array(
							'default' => '',
							'name' => __( 'Post ID', 'su' ),
							'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'su' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'su' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'su' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'Post meta', 'su' ),
					'icon' => 'info-circle'
				),
				// user
				'user' => array(
					'name' => __( 'User', 'su' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'field' => array(
							'type' => 'select',
							'values' => array(
								'display_name'        => __( 'Display name', 'su' ),
								'ID'                  => __( 'ID', 'su' ),
								'user_login'          => __( 'Login', 'su' ),
								'user_nicename'       => __( 'Nice name', 'su' ),
								'user_email'          => __( 'Email', 'su' ),
								'user_url'            => __( 'URL', 'su' ),
								'user_registered'     => __( 'Registered', 'su' ),
								'user_activation_key' => __( 'Activation key', 'su' ),
								'user_status'         => __( 'Status', 'su' )
							),
							'default' => 'display_name',
							'name' => __( 'Field', 'su' ),
							'desc' => __( 'User data field name', 'su' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'su' ),
							'desc' => __( 'This text will be shown if data is not found', 'su' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'su' ),
							'desc' => __( 'This content will be shown before the value', 'su' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'su' ),
							'desc' => __( 'This content will be shown after the value', 'su' )
						),
						'user_id' => array(
							'default' => '',
							'name' => __( 'User ID', 'su' ),
							'desc' => __( 'You can specify custom user ID. Leave this field empty to use an ID of the current user', 'su' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'su' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'su' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'User data', 'su' ),
					'icon' => 'info-circle'
				),
				// post
				'post' => array(
					'name' => __( 'Post', 'su' ),
					'type' => 'single',
					'group' => 'data',
					'atts' => array(
						'field' => array(
							'type' => 'select',
							'values' => array(
								'ID'                    => __( 'Post ID', 'su' ),
								'post_author'           => __( 'Post author', 'su' ),
								'post_date'             => __( 'Post date', 'su' ),
								'post_date_gmt'         => __( 'Post date', 'su' ) . ' GMT',
								'post_content'          => __( 'Post content', 'su' ),
								'post_title'            => __( 'Post title', 'su' ),
								'post_excerpt'          => __( 'Post excerpt', 'su' ),
								'post_status'           => __( 'Post status', 'su' ),
								'comment_status'        => __( 'Comment status', 'su' ),
								'ping_status'           => __( 'Ping status', 'su' ),
								'post_name'             => __( 'Post name', 'su' ),
								'post_modified'         => __( 'Post modified', 'su' ),
								'post_modified_gmt'     => __( 'Post modified', 'su' ) . ' GMT',
								'post_content_filtered' => __( 'Filtered post content', 'su' ),
								'post_parent'           => __( 'Post parent', 'su' ),
								'guid'                  => __( 'GUID', 'su' ),
								'menu_order'            => __( 'Menu order', 'su' ),
								'post_type'             => __( 'Post type', 'su' ),
								'post_mime_type'        => __( 'Post mime type', 'su' ),
								'comment_count'         => __( 'Comment count', 'su' )
							),
							'default' => 'post_title',
							'name' => __( 'Field', 'su' ),
							'desc' => __( 'Post data field name', 'su' )
						),
						'default' => array(
							'default' => '',
							'name' => __( 'Default', 'su' ),
							'desc' => __( 'This text will be shown if data is not found', 'su' )
						),
						'before' => array(
							'default' => '',
							'name' => __( 'Before', 'su' ),
							'desc' => __( 'This content will be shown before the value', 'su' )
						),
						'after' => array(
							'default' => '',
							'name' => __( 'After', 'su' ),
							'desc' => __( 'This content will be shown after the value', 'su' )
						),
						'post_id' => array(
							'default' => '',
							'name' => __( 'Post ID', 'su' ),
							'desc' => __( 'You can specify custom post ID. Leave this field empty to use an ID of the current post. Current post ID may not work in Live Preview mode', 'su' )
						),
						'filter' => array(
							'default' => '',
							'name' => __( 'Filter', 'su' ),
							'desc' => __( 'You can apply custom filter to the retrieved value. Enter here function name. Your function must accept one argument and return modified value. Example function: ', 'su' ) . "<br /><pre><code style='display:block;padding:5px'>function my_custom_filter( \$value ) {\n\treturn 'Value is: ' . \$value;\n}</code></pre>"
						)
					),
					'desc' => __( 'Post data', 'su' ),
					'icon' => 'info-circle'
				),
				// template
				'template' => array(
					'name' => __( 'Template', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'name' => array(
							'default' => '',
							'name' => __( 'Template name', 'su' ),
							'desc' => sprintf( __( 'Use template file name (with optional .php extension). If you need to use templates from theme sub-folder, use relative path. Example values: %s, %s, %s', 'su' ), '<b%value>page</b>', '<b%value>page.php</b>', '<b%value>includes/page.php</b>' )
						)
					),
					'desc' => __( 'Theme template', 'su' ),
					'icon' => 'puzzle-piece'
				),
			) );
		// Return result
		return ( is_string( $shortcode ) ) ? $shortcodes[sanitize_text_field( $shortcode )] : $shortcodes;
	}
}


class Shortcodes_Ultimate_Data extends Su_Data {
	function __construct() {
		parent::__construct();
	}
}

 
 


 
   

Status
 API
 Training
 Shop
 Blog
 About
   © 2014 GitHub, Inc.
 Terms
 Privacy
 Security
 Contact
   








          




